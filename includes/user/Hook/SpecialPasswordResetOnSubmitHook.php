<?php

namespace MediaWiki\User\Hook;

use MessageSpecifier;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialPasswordResetOnSubmit" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialPasswordResetOnSubmitHook
{
    /**
     * This hook is called when executing a form submission on Special:PasswordReset.
     *
     * @param User[] &$users
     * @param array $data Array of data submitted by the user
     * @param string|array|MessageSpecifier &$error String, error code (message key)
     *   used to describe to error (out parameter). The hook needs to return false
     *   when setting this, otherwise it will have no effect.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialPasswordResetOnSubmit(&$users, $data, &$error);
}
