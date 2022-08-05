<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ImportLogInterwikiLink" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ImportLogInterwikiLinkHook
{
    /**
     * Use this hook to change interwiki links in log entries and edit summaries for transwiki imports
     *
     * @param string &$fullInterwikiPrefix Interwiki prefix, may contain colons.
     * @param string &$pageTitle String that contains page title.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onImportLogInterwikiLink(&$fullInterwikiPrefix, &$pageTitle);
}
