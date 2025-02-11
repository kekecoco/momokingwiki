<?php

namespace MediaWiki\Auth\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserLoggedIn" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserLoggedInHook
{
    /**
     * This hook is called after a user is logged in.
     *
     * @param User $user User object for the logged-in user
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserLoggedIn($user);
}
