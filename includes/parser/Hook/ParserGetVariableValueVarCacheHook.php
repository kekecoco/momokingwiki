<?php

namespace MediaWiki\Hook;

use Parser;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserGetVariableValueVarCache" to register handlers implementing this interface.
 *
 * @deprecated since 1.35
 * @ingroup Hooks
 */
interface ParserGetVariableValueVarCacheHook
{
    /**
     * Use this hook to change the value of the variable
     * cache or return false to not use it.
     *
     * @param Parser $parser
     * @param array &$varCache Variable cache
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserGetVariableValueVarCache($parser, &$varCache);
}
