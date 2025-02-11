<?php

namespace MediaWiki\Permissions\Hook;

use MessageSpecifier;
use Title;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "getUserPermissionsErrorsExpensive" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetUserPermissionsErrorsExpensiveHook
{
    /**
     * This hook is equal to getUserPermissionsErrors, but it is called only if
     * expensive checks are enabled. Use this hook to add a permissions error when
     * permissions errors are checked for. Return false if the user can't do it, and
     * populate $result with the reason in the form of [ messagename, param1, param2,
     * ... ] or a MessageSpecifier instance (you might want to use ApiMessage to
     * provide machine-readable details for the API).
     *
     * @param Title $title Title being checked against
     * @param User $user Current user
     * @param string $action Action being checked
     * @param array|string|MessageSpecifier &$result User permissions error to add. If none, return true.
     *   For consistency, error messages should be plain text with no special coloring,
     *   bolding, etc. to show that they're errors; presenting them properly to the
     *   user as errors is done by the caller.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetUserPermissionsErrorsExpensive($title, $user, $action,
                                                        &$result
    );
}
