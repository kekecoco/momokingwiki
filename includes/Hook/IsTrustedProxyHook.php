<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "IsTrustedProxy" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface IsTrustedProxyHook
{
    /**
     * Use this hook to override the result of ProxyLookup::isTrustedProxy().
     *
     * @param string $ip IP being checked
     * @param bool &$result Change this value to override the result of ProxyLookup::isTrustedProxy()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onIsTrustedProxy($ip, &$result);
}
