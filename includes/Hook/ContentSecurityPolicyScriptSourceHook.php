<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ContentSecurityPolicyScriptSource" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ContentSecurityPolicyScriptSourceHook
{
    /**
     * Use this hook to modify the allowed CSP script sources.
     * Note that you also have to use ContentSecurityPolicyDefaultSource if you
     * want non-script sources to be loaded from whatever you add.
     *
     * @param string[] &$scriptSrc Array of CSP directives
     * @param array $policyConfig Current configuration for the CSP header
     * @param int $mode ContentSecurityPolicy::REPORT_ONLY_MODE or
     *   ContentSecurityPolicy::FULL_MODE depending on type of header
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onContentSecurityPolicyScriptSource(&$scriptSrc,
                                                        $policyConfig, $mode
    );
}
