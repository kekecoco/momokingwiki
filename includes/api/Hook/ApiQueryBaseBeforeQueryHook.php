<?php

namespace MediaWiki\Api\Hook;

use ApiQueryBase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiQueryBaseBeforeQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiQueryBaseBeforeQueryHook
{
    /**
     * This hook is called for (some) API query modules before a
     * database query is made. WARNING: It would be very easy to misuse this hook and
     * break the module! Any joins added *must* join on a unique key of the target
     * table unless you really know what you're doing. An API query module wanting to
     * use this hook should see the ApiQueryBase::select() and
     * ApiQueryBase::processRow() documentation.
     *
     * @param ApiQueryBase $module Module in question
     * @param array &$tables Array of tables to be queried
     * @param array &$fields Array of columns to select
     * @param array &$conds Array of WHERE conditionals for query
     * @param array &$query_options Array of options for the database request
     * @param array &$join_conds Join conditions for the tables
     * @param array &$hookData Array that will be passed to the ApiQueryBaseAfterQuery and
     *   ApiQueryBaseProcessRow hooks, intended for inter-hook communication.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onApiQueryBaseBeforeQuery($module, &$tables, &$fields,
                                              &$conds, &$query_options, &$join_conds, &$hookData
    );
}
