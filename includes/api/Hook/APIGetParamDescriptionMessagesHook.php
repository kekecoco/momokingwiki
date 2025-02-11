<?php

namespace MediaWiki\Api\Hook;

use ApiBase;
use Message;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "APIGetParamDescriptionMessages" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface APIGetParamDescriptionMessagesHook
{
    /**
     * Use this hook to modify a module's parameter descriptions.
     *
     * @param ApiBase $module
     * @param Message[][] &$msg
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAPIGetParamDescriptionMessages($module, &$msg);
}
