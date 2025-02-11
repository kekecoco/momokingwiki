<?php

namespace MediaWiki\Hook;

use HistoryPager;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PageHistoryPager::getQueryInfo" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PageHistoryPager__getQueryInfoHook
{
    /**
     * This hook is called when a history pager query parameter set is constructed.
     *
     * @param HistoryPager $pager
     * @param array &$queryInfo The query parameters
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onPageHistoryPager__getQueryInfo($pager, &$queryInfo);
}
