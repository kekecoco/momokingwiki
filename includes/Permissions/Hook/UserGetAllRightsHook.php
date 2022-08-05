<?php

namespace MediaWiki\Permissions\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserGetAllRights" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserGetAllRightsHook
{
    /**
     * This hook is called after calculating a list of all available rights.
     *
     * @param string[] &$rights Array of rights, which may be added to
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserGetAllRights(&$rights);
}
