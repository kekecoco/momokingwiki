<?php

namespace MediaWiki\Hook;

use Status;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MovePageIsValidMove" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MovePageIsValidMoveHook
{
    /**
     * Use this hook to specify whether a page can be moved for technical reasons.
     *
     * @param Title $oldTitle Current (old) location
     * @param Title $newTitle New location
     * @param Status $status Status object to pass error messages to
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMovePageIsValidMove($oldTitle, $newTitle, $status);
}
