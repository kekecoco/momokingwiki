<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetMagicVariableIDs" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetMagicVariableIDsHook
{
    /**
     * Use this hook to modify the list of magic variables.
     * Magic variables are localized with the magic word system,
     * and this hook is called by MagicWordFactory.
     *
     * @param string[] &$variableIDs array of magic word identifiers
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetMagicVariableIDs(&$variableIDs);
}
