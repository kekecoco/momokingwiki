<?php

namespace MediaWiki\Permissions\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserIsEveryoneAllowed" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserIsEveryoneAllowedHook
{
    /**
     * Use this hook to check if all users are allowed some user right; return
     * false if a UserGetRights hook might remove the named right.
     *
     * @param string $right User right being checked
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserIsEveryoneAllowed($right);
}
