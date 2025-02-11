<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GitViewers" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GitViewersHook
{
    /**
     * This hook is called when generating the list of git viewers for Special:Version,
     * allowing you to modify the list.
     *
     * @param string[] &$extTypes Associative array of repo URLS to viewer URLs
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGitViewers(&$extTypes);
}
