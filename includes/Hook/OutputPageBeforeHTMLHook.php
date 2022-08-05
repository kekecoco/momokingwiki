<?php

namespace MediaWiki\Hook;

use OutputPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "OutputPageBeforeHTML" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface OutputPageBeforeHTMLHook
{
    /**
     * This hook is called when a page has been processed by the parser and the
     * resulting HTML is about to be displayed.
     *
     * @param OutputPage $out OutputPage object that corresponds to the page
     * @param string &$text Text that will be displayed, in HTML
     * @return bool|void This hook must not abort, it must return true or null.
     * @since 1.35
     *
     */
    public function onOutputPageBeforeHTML($out, &$text);
}
