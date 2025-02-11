<?php

namespace MediaWiki\Api\Hook;

use ApiBase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "APIGetAllowedParams" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface APIGetAllowedParamsHook
{
    /**
     * Use this hook to modify a module's parameters.
     *
     * @param ApiBase $module
     * @param array &$params Array of parameters
     * @param int $flags Zero or OR-ed flags like ApiBase::GET_VALUES_FOR_HELP
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAPIGetAllowedParams($module, &$params, $flags);
}
