<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "TitleIsMovable" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface TitleIsMovableHook
{
    /**
     * This hook is called when determining if it is possible to move a page. Note
     * that this hook is not called for interwiki pages or pages in immovable
     * namespaces: for these, isMovable() always returns false.
     *
     * @param Title $title Title object that is being checked
     * @param bool &$result Whether MediaWiki currently thinks this page is movable.
     *   Hooks may change this value to override the return value of
     *   Title::isMovable().
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onTitleIsMovable($title, &$result);
}
