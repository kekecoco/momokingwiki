<?php

namespace MediaWiki\Hook;

use Parser;
use StripState;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserAfterParse" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserAfterParseHook
{
    /**
     * This hook is called from Parser::parse() just after the call to
     * Parser::internalParse() returns.
     *
     * @param Parser $parser
     * @param string &$text Text being parsed
     * @param StripState $stripState StripState used
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserAfterParse($parser, &$text, $stripState);
}
