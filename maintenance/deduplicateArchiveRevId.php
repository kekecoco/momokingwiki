<?php

use Wikimedia\Rdbms\IDatabase;

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script that cleans up archive rows with duplicated ar_rev_id,
 * both within archive and between archive and revision.
 *
 * @ingroup Maintenance
 * @since 1.32
 */
class DeduplicateArchiveRevId extends LoggedUpdateMaintenance
{

    private $deleted = 0;
    private $reassigned = 0;

    public function __construct()
    {
        parent::__construct();
        $this->addDescription(
            'Clean up duplicate ar_rev_id, both within archive and between archive and revision.'
        );
        $this->setBatchSize(10000);
    }

    protected function getUpdateKey()
    {
        return __CLASS__;
    }

    protected function doDBUpdates()
    {
        $this->output("Deduplicating ar_rev_id...\n");
        $dbw = $this->getDB(DB_PRIMARY);
        // If this is a new install, we don't need to do anything here.
        if (PopulateArchiveRevId::isNewInstall($dbw)) {
            $this->output("New install, nothing to do here.\n");

            return true;
        }

        PopulateArchiveRevId::checkMysqlAutoIncrementBug($dbw);

        $minId = $dbw->newSelectQueryBuilder()
            ->select('MIN(ar_rev_id)')
            ->from('archive')
            ->options([])
            ->caller(__METHOD__)
            ->fetchField();
        $maxId = $dbw->newSelectQueryBuilder()
            ->select('MAX(ar_rev_id)')
            ->from('archive')
            ->options([])
            ->caller(__METHOD__)
            ->fetchField();
        $batchSize = $this->getBatchSize();

        $revActorQuery = ActorMigration::newMigration()->getJoin('rev_user');

        for ($id = $minId; $id <= $maxId; $id += $batchSize) {
            $endId = min($maxId, $id + $batchSize - 1);

            $this->beginTransaction($dbw, __METHOD__);

            // Lock the archive and revision table rows for the IDs we're checking
            // to try to prevent deletions or undeletions from confusing things.
            $dbw->newSelectQueryBuilder()
                ->select('1')
                ->from('archive')
                ->where(['ar_rev_id >= ' . (int)$id, 'ar_rev_id <= ' . (int)$endId])
                ->caller(__METHOD__)
                ->forUpdate()
                ->fetchRowCount();
            $dbw->newSelectQueryBuilder()
                ->select('1')
                ->from('archive')
                ->where(['ar_rev_id >= ' . (int)$id, 'ar_rev_id <= ' . (int)$endId])
                ->caller(__METHOD__)
                ->lockInShareMode()
                ->fetchRowCount();

            // Figure out the ar_rev_ids we actually need to look at
            $res = $dbw->newSelectQueryBuilder()
                ->select(['rev_id', 'rev_timestamp', 'rev_sha1'] + $revActorQuery['fields'])
                ->tables(['archive', 'revision'] + $revActorQuery['tables'])
                ->where(['ar_rev_id >= ' . (int)$id, 'ar_rev_id <= ' . (int)$endId])
                ->caller(__METHOD__)
                ->distinct()
                ->joinConds(['revision', ['ar_rev_id = rev_id']] + $revActorQuery['joins'])
                ->fetchResultSet();
            $revRows = [];
            foreach ($res as $row) {
                $revRows[$row->rev_id] = $row;
            }

            $arRevIds = $dbw->newSelectQueryBuilder()
                ->select('ar_rev_id')
                ->from('archive')
                ->where(['ar_rev_id >= ' . (int)$id, 'ar_rev_id <= ' . (int)$endId])
                ->caller(__METHOD__)
                ->groupBy('ar_rev_id')
                ->having('COUNT(*) > 1')
                ->fetchFieldValues();
            $arRevIds = array_values(array_unique(array_merge($arRevIds, array_keys($revRows))));

            if ($arRevIds) {
                $this->processArRevIds($dbw, $arRevIds, $revRows);
            }

            $this->output("... $id-$endId\n");
            $this->commitTransaction($dbw, __METHOD__);
        }

        $this->output(
            "Finished deduplicating ar_rev_id. $this->deleted rows deleted, "
            . "$this->reassigned assigned new IDs.\n"
        );

        return true;
    }

    /**
     * Process a set of ar_rev_ids
     * @param IDatabase $dbw
     * @param int[] $arRevIds IDs to process
     * @param stdClass[] $revRows Existing revision-table row data
     */
    private function processArRevIds(IDatabase $dbw, array $arRevIds, array $revRows)
    {
        // Select all the data we need for deduplication
        $res = $dbw->newSelectQueryBuilder()
            ->select(['ar_id', 'ar_rev_id', 'ar_namespace', 'ar_title', 'ar_actor',
                'ar_timestamp', 'ar_sha1'])
            ->from('archive')
            ->where(['ar_rev_id' => $arRevIds])
            ->caller(__METHOD__)
            ->fetchResultSet();

        // Determine which rows we need to delete or reassign
        $seen = [];
        $toDelete = [];
        $toReassign = [];
        foreach ($res as $row) {
            // Revision-table row exists?
            if (isset($revRows[$row->ar_rev_id])) {
                $revRow = $revRows[$row->ar_rev_id];

                // Record the rev_id as seen, so the code below will always delete or reassign.
                if (!isset($seen[$revRow->rev_id])) {
                    $seen[$revRow->rev_id] = [
                        'first' => "revision row",
                    ];
                }

                // Delete the archive row if it seems to be the same regardless
                // of page, because moves can change IDs and titles.
                if ($row->ar_timestamp === $revRow->rev_timestamp &&
                    $row->ar_sha1 === $revRow->rev_sha1 &&
                    $row->ar_actor === $revRow->rev_actor
                ) {
                    $this->output(
                        "Row $row->ar_id duplicates revision row for rev_id $revRow->rev_id, deleting\n"
                    );
                    $toDelete[] = $row->ar_id;
                    continue;
                }
            }

            $key = $this->getSeenKey($row);
            if (!isset($seen[$row->ar_rev_id])) {
                // This rev_id hasn't even been seen yet, nothing to do besides record it.
                $seen[$row->ar_rev_id] = [
                    'first' => "archive row $row->ar_id",
                    $key    => $row->ar_id,
                ];
            } elseif (!isset($seen[$row->ar_rev_id][$key])) {
                // The rev_id was seen, but not this particular change. Reassign it.
                $seen[$row->ar_rev_id][$key] = $row->ar_id;
                $this->output(
                    "Row $row->ar_id conflicts with {$seen[$row->ar_rev_id]['first']} "
                    . "for rev_id $row->ar_rev_id, reassigning\n"
                );
                $toReassign[] = $row->ar_id;
            } else {
                // The rev_id was seen with a row that matches this change. Delete it.
                $this->output(
                    "Row $row->ar_id duplicates archive row {$seen[$row->ar_rev_id][$key]} "
                    . "for rev_id $row->ar_rev_id, deleting\n"
                );
                $toDelete[] = $row->ar_id;
            }
        }

        // Perform the updates
        if ($toDelete) {
            $dbw->delete('archive', ['ar_id' => $toDelete], __METHOD__);
            $this->deleted += $dbw->affectedRows();
        }
        if ($toReassign) {
            $this->reassigned += PopulateArchiveRevId::reassignArRevIds($dbw, $toReassign);
        }
    }

    /**
     * Make a key identifying a "unique" change from a row
     * @param stdClass $row
     * @return string
     */
    private function getSeenKey($row)
    {
        return implode("\n", [
            $row->ar_namespace,
            $row->ar_title,
            $row->ar_timestamp,
            $row->ar_sha1,
            $row->ar_actor,
        ]);
    }

}

$maintClass = DeduplicateArchiveRevId::class;
require_once RUN_MAINTENANCE_IF_MAIN;
