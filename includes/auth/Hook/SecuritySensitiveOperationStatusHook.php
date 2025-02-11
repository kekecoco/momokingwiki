<?php

namespace MediaWiki\Auth\Hook;

use MediaWiki\Session\Session;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SecuritySensitiveOperationStatus" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SecuritySensitiveOperationStatusHook
{
    /**
     * Use this hook to affect the return value from
     * MediaWiki\Auth\AuthManager::securitySensitiveOperationStatus().
     *
     * @param string &$status Status to be returned. One of the AuthManager::SEC_*
     *   constants. SEC_REAUTH will be automatically changed to SEC_FAIL if
     *   authentication isn't possible for the current session type.
     * @param string $operation Operation being checked
     * @param Session $session Current session. The currently-authenticated user may
     *   be retrieved as $session->getUser().
     * @param int $timeSinceAuth Time since last authentication. PHP_INT_MAX if
     *   the time of last auth is unknown, or -1 if authentication is not possible.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSecuritySensitiveOperationStatus(&$status, $operation,
                                                       $session, $timeSinceAuth
    );
}
