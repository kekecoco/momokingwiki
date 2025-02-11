<?php

namespace MediaWiki\Hook;

use Title;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "TitleMoveStarting" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface TitleMoveStartingHook
{
    /**
     * This hook is called before moving an article (title), but just after the atomic
     * DB section starts.
     *
     * @param Title $old Old title
     * @param Title $nt New title
     * @param User $user User who does the move
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onTitleMoveStarting($old, $nt, $user);
}
