<?php

namespace MediaWiki\Hook;

use RecentChange;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "IRCLineURL" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface IRCLineURLHook
{
    /**
     * This hook is called when constructing the URL to use in an IRC notification.
     * Callee may modify $url and $query; URL will be constructed as $url . $query
     *
     * @param string &$url URL to index.php
     * @param string &$query Query string
     * @param RecentChange $rc RecentChange object that triggered URL generation
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onIRCLineURL(&$url, &$query, $rc);
}
