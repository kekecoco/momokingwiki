<?php

namespace MediaWiki\Revision\Hook;

use MediaWiki\Revision\RevisionRecord;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "RevisionRecordInserted" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface RevisionRecordInsertedHook
{
    /**
     * This hook is called after a revision is inserted into the database.
     *
     * @param RevisionRecord $revisionRecord RevisionRecord that has just been inserted
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onRevisionRecordInserted($revisionRecord);
}
