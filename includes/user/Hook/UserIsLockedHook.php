<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserIsLocked" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserIsLockedHook
{
    /**
     * Use this hook to establish that a user is locked. See User::isLocked().
     *
     * @param User $user User in question.
     * @param bool &$locked Set true if the user should be locked.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserIsLocked($user, &$locked);
}
