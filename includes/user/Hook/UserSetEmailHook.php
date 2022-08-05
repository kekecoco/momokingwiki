<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserSetEmail" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserSetEmailHook
{
    /**
     * This hook is called when changing user email address.
     *
     * @param User $user
     * @param string &$email new email, change this to override new email address
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserSetEmail($user, &$email);
}
