<?php

namespace MediaWiki\Permissions\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserGetRightsRemove" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserGetRightsRemoveHook
{
    /**
     * This hook is called in PermissionManager::getUserPermissions(). This hook
     * overrides the UserGetRights hook. It can be used to remove rights from a user
     * and ensure that they will not be reinserted by the other hook callbacks.
     * This hook should not be used to add any rights; use UserGetRights instead.
     *
     * @param User $user User to get rights for
     * @param string[] &$rights Current rights
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserGetRightsRemove($user, &$rights);
}
