<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialSearchCreateLink" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialSearchCreateLinkHook
{
    /**
     * This hook is called when making the message to create a page or go to the existing page.
     *
     * @param Title $t Title object searched for
     * @param array &$params An array of the default message name and page title (as parameter)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialSearchCreateLink($t, &$params);
}
