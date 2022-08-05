<?php

namespace MediaWiki\Api\Hook;

use ApiQueryWatchlist;
use WatchedItem;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiQueryWatchlistExtractOutputData" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiQueryWatchlistExtractOutputDataHook
{
    /**
     * Use this hook to extract row data for ApiQueryWatchlist.
     *
     * @param ApiQueryWatchlist $module
     * @param WatchedItem $watchedItem
     * @param array $recentChangeInfo Array of recent change info data
     * @param array &$vals Associative array of data to be output for the row
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onApiQueryWatchlistExtractOutputData($module, $watchedItem,
                                                         $recentChangeInfo, &$vals
    );
}
