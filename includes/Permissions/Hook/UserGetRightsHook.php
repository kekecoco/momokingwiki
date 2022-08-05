<?php

namespace MediaWiki\Permissions\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserGetRights" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserGetRightsHook
{
    /**
     * This hook is called in PermissionManager::getUserPermissions().
     *
     * @param User $user User to get rights for
     * @param string[] &$rights Current rights
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserGetRights($user, &$rights);
}
