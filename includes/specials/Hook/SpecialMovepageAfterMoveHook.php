<?php

namespace MediaWiki\Hook;

use MovePageForm;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialMovepageAfterMove" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialMovepageAfterMoveHook
{
    /**
     * This hook is called after moving a page.
     *
     * @param MovePageForm $movePage
     * @param Title $oldTitle
     * @param Title $newTitle
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialMovepageAfterMove($movePage, $oldTitle, $newTitle);
}
