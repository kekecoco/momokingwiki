<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetDoubleUnderscoreIDs" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetDoubleUnderscoreIDsHook
{
    /**
     * Use this hook to modify the list of behavior switches (double
     * underscore variables in wikitext).  Behavior switches are localized
     * with the magic word system, and this hook is called by
     * MagicWordFactory.
     *
     * @param string[] &$doubleUnderscoreIDs Array of magic word identifiers
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetDoubleUnderscoreIDs(&$doubleUnderscoreIDs);
}
