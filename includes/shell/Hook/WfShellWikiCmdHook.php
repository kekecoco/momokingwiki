<?php

namespace MediaWiki\Shell\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "wfShellWikiCmd" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface WfShellWikiCmdHook
{
    /**
     * This hook is called when generating a shell-escaped command line string to
     * run a MediaWiki CLI script.
     *
     * @param string &$script MediaWiki CLI script path
     * @param string[] &$parameters Array of arguments and options to the script
     * @param array &$options Associative array of options, may contain the 'php' and 'wrapper'
     *   keys
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onWfShellWikiCmd(&$script, &$parameters, &$options);
}
