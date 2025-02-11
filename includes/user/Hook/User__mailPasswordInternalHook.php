<?php

namespace MediaWiki\User\Hook;

use User;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "User::mailPasswordInternal" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface User__mailPasswordInternalHook
{
    /**
     * This hook is called before creation and mailing of a user's new temporary password.
     *
     * @param User $user The user who sent the message out
     * @param string $ip IP of the user who sent the message out
     * @param User $u The account whose new password will be set
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUser__mailPasswordInternal($user, $ip, $u);
}
