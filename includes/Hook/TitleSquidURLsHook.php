<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "TitleSquidURLs" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface TitleSquidURLsHook
{
    /**
     * This hook is called to determine which URLs to purge from HTTP caches.
     *
     * @param Title $title Title object to purge
     * @param string[] &$urls Array of URLs to purge from the caches, to be manipulated
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onTitleSquidURLs($title, &$urls);
}
