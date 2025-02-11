<?php

namespace MediaWiki\Hook;

use Parser;
use StripState;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserBeforePreprocess" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserBeforePreprocessHook
{
    /**
     * Called at the beginning of Parser::preprocess()
     *
     * @param Parser $parser
     * @param string &$text text to parse
     * @param StripState $stripState StripState instance being used
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserBeforePreprocess($parser, &$text, $stripState);
}
