<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserRemoveGroup" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserRemoveGroupHook
{
    /**
     * This hook is called when removing a group.
     *
     * @param User $user The user that is to have a group removed
     * @param string &$group The group to be removed. Can be modified.
     * @return bool|void True or no return value to continue or false to abort (override
     *   the stock group removal)
     * @since 1.35
     *
     */
    public function onUserRemoveGroup($user, &$group);
}
