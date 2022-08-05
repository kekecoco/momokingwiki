<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "InvalidateEmailComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface InvalidateEmailCompleteHook
{
    /**
     * This hook is called after a user's email has been invalidated successfully.
     *
     * @param User $user User whose email is being invalidated
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onInvalidateEmailComplete($user);
}
