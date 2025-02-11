<?php

namespace MediaWiki\Hook;

use HistoryPager;
use Wikimedia\Rdbms\IResultWrapper;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PageHistoryPager::doBatchLookups" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PageHistoryPager__doBatchLookupsHook
{
    /**
     * This hook is called after the pager query was run, before any output is generated,
     * to allow batch lookups for prefetching information needed for display.
     *
     * @param HistoryPager $pager
     * @param IResultWrapper $result A ResultWrapper representing the query result
     * @return bool|void True or no return value to continue. False to skip the
     *   regular behavior of doBatchLookups().
     * @since 1.35
     *
     */
    public function onPageHistoryPager__doBatchLookups($pager, $result);
}
