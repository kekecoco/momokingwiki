<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserIsBot" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserIsBotHook
{
    /**
     * Use this hook to establish whether a user is a bot account.
     *
     * @param User $user
     * @param bool &$isBot Whether this is user a bot or not (boolean)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserIsBot($user, &$isBot);
}
