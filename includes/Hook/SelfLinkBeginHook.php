<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SelfLinkBegin" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SelfLinkBeginHook
{
    /**
     * This hook is called before a link to the current article is displayed to
     * allow the display of the link to be customized.
     *
     * @param Title $nt
     * @param string &$html HTML to display for the link
     * @param string &$trail Optional text to display before $html
     * @param string &$prefix Optional text to display after $html
     * @param string &$ret Value to return if your hook returns false
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSelfLinkBegin($nt, &$html, &$trail, &$prefix, &$ret);
}
