<?php

namespace MediaWiki\User\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserAddGroup" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserAddGroupHook
{
    /**
     * This hook is called when adding a group or changing a group's expiry.
     *
     * @param User $user The user that is to have a group added
     * @param string &$group The group to add; can be modified
     * @param string|null &$expiry The expiry time in TS_MW format, or null if the group is not to
     *   expire; can be modified
     * @return bool|void True or no return value to continue or false to abort (not add the group)
     * @since 1.35
     *
     */
    public function onUserAddGroup($user, &$group, &$expiry);
}
