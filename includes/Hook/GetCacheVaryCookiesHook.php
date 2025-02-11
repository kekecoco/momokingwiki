<?php

namespace MediaWiki\Hook;

use OutputPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetCacheVaryCookies" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetCacheVaryCookiesHook
{
    /**
     * Use this hook to get cookies that should vary cache options.
     *
     * @param OutputPage $out
     * @param string[] &$cookies Array of cookie names. Add a value to it if you
     *   want to add a cookie that has to vary cache options.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetCacheVaryCookies($out, &$cookies);
}
