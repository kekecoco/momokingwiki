<?php

namespace MediaWiki\Hook;

use Wikimedia\Rdbms\IDatabase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ModifyExportQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ModifyExportQueryHook
{
    /**
     * Use this hook to modify the query used by the exporter.
     *
     * @param IDatabase $db Database object to be queried
     * @param array &$tables Tables in the query
     * @param string $cond An SQL fragment included in the WHERE clause which is used to filter
     *   the results, for example to a specific page. Since 1.31, modification of this
     *   parameter has no effect. Since 1.35, you can use $conds instead to modify the
     *   array of conditions passed to IDatabase::select().
     * @param array &$opts Options for the query
     * @param array &$join_conds Join conditions for the query
     * @param array &$conds The array of conditions to be passed to IDatabase::select(). Can be
     *   modified. Includes the value of $cond.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onModifyExportQuery($db, &$tables, $cond, &$opts,
                                        &$join_conds, &$conds
    );
}
