<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialWatchlistGetNonRevisionTypes" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialWatchlistGetNonRevisionTypesHook
{
    /**
     * This hook is called when building the SQL query for SpecialWatchlist.
     *
     * It allows extensions to register custom values they have
     * inserted to rc_type so they can be returned as part of the watchlist.
     *
     * @param int[] &$nonRevisionTypes Array of values in the rc_type field of
     *   the recentchanges table
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialWatchlistGetNonRevisionTypes(&$nonRevisionTypes);
}
