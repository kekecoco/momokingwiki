<?php

namespace MediaWiki\Hook;

use EditPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EditPageNoSuchSection" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EditPageNoSuchSectionHook
{
    /**
     * This hook is called when a section edit request is given for an non-existent section.
     *
     * @param EditPage $editpage Current EditPage object
     * @param string &$res HTML of the error text
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onEditPageNoSuchSection($editpage, &$res);
}
