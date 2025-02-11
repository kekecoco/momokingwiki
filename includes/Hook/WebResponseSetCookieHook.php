<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "WebResponseSetCookie" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface WebResponseSetCookieHook
{
    /**
     * This hook is called when setting a cookie in WebResponse::setcookie().
     *
     * @param string &$name Cookie name passed to WebResponse::setcookie()
     * @param string &$value Cookie value passed to WebResponse::setcookie()
     * @param int|null &$expire Cookie expiration, as for PHP's setcookie()
     * @param array &$options Options passed to WebResponse::setcookie()
     * @return bool|void True or no return value to continue, or false to prevent setting of the cookie
     * @since 1.35
     *
     */
    public function onWebResponseSetCookie(&$name, &$value, &$expire, &$options);
}
