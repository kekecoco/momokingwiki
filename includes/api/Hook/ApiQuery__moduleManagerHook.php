<?php

namespace MediaWiki\Api\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
use ApiModuleManager;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiQuery::moduleManager" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiQuery__moduleManagerHook
{
    /**
     * This hook is called when ApiQuery has finished initializing its
     * module manager. Use this hook to conditionally register API query modules.
     *
     * @param ApiModuleManager $moduleManager
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onApiQuery__moduleManager($moduleManager);
}
