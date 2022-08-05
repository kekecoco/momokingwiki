<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "AfterBuildFeedLinks" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface AfterBuildFeedLinksHook
{
    /**
     * This hook is called in OutputPage.php after all feed links (atom,
     * rss,...) are created. Use this hook to omit specific feeds from being outputted.
     * You must not use this hook to add feeds; use OutputPage::addFeedLink() instead.
     *
     * @param string[] &$feedLinks Array of created feed links
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAfterBuildFeedLinks(&$feedLinks);
}
