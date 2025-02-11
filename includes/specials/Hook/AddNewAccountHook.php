<?php

namespace MediaWiki\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "AddNewAccount" to register handlers implementing this interface.
 *
 * @deprecated since 1.27. Use LocalUserCreated instead.
 * @ingroup Hooks
 */
interface AddNewAccountHook
{
    /**
     * This hook is called after a user account is created.
     *
     * @param User $user the User object that was created. (Parameter added in 1.7)
     * @param bool $byEmail true when account was created "by email" (added in 1.12)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAddNewAccount($user, $byEmail);
}
