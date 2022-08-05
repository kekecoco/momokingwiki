<?php

namespace MediaWiki\Hook;

use EditPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EditFormInitialText" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EditFormInitialTextHook
{
    /**
     * Use this hook to modify the edit form when editing existing pages.
     *
     * @param EditPage $editPage
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onEditFormInitialText($editPage);
}
