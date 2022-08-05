<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "RecentChangesPurgeRows" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface RecentChangesPurgeRowsHook
{
    /**
     * This hook is called when old recentchanges rows are purged, after
     * deleting those rows but within the same transaction.
     *
     * @param \stdClass[] $rows Deleted rows as an array of recentchanges row objects (with up to
     *   $wgUpdateRowsPerQuery items)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onRecentChangesPurgeRows($rows);
}
