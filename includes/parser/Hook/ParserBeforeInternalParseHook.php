<?php

namespace MediaWiki\Hook;

use Parser;
use StripState;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserBeforeInternalParse" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserBeforeInternalParseHook
{
    /**
     * This hook is called at the beginning of Parser::internalParse().
     *
     * @param Parser $parser
     * @param string &$text Text to parse
     * @param StripState $stripState StripState instance being used
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserBeforeInternalParse($parser, &$text, $stripState);
}
