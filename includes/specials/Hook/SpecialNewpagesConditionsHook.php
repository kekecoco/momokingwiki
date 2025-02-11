<?php

namespace MediaWiki\Hook;

use FormOptions;
use NewPagesPager;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialNewpagesConditions" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialNewpagesConditionsHook
{
    /**
     * This hook is called when building the SQL query for Special:NewPages.
     *
     * @param NewPagesPager $special NewPagesPager object (subclass of ReverseChronologicalPager)
     * @param FormOptions $opts FormOptions object containing special page options
     * @param array &$conds array of WHERE conditionals for query
     * @param array &$tables array of tables to be queried
     * @param array &$fields array of columns to select
     * @param array &$join_conds join conditions for the tables
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialNewpagesConditions($special, $opts, &$conds,
                                                &$tables, &$fields, &$join_conds
    );
}
