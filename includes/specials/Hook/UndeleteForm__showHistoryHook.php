<?php

namespace MediaWiki\Hook;

use PageArchive;
use Title;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UndeleteForm::showHistory" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UndeleteForm__showHistoryHook
{
    /**
     * This hook is called in UndeleteForm::showHistory, after creating the PageArchive object
     *
     * @param PageArchive &$archive PageArchive object
     * @param Title $title Title object of the page that we're viewing
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUndeleteForm__showHistory(&$archive, $title);
}
