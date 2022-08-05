<?php

namespace MediaWiki\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PasswordPoliciesForUser" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PasswordPoliciesForUserHook
{
    /**
     * Use this hook to alter the effective password policy for a user.
     *
     * @param User $user User whose policy you are modifying
     * @param array &$effectivePolicy Array of policy statements that apply to this user
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onPasswordPoliciesForUser($user, &$effectivePolicy);
}
