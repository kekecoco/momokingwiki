<?php

namespace MediaWiki\Diff\Hook;

use DifferenceEngine;
use OutputPage;
use ParserOutput;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineRenderRevisionAddParserOutput" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineRenderRevisionAddParserOutputHook
{
    /**
     * Use this hook to change the parser output.
     *
     * @param DifferenceEngine $differenceEngine
     * @param OutputPage $out
     * @param ParserOutput $parserOutput
     * @param WikiPage $wikiPage
     * @return bool|void True or no return value to continue, or false to not add parser output via
     *   OutputPage's addParserOutput method
     * @since 1.35
     *
     */
    public function onDifferenceEngineRenderRevisionAddParserOutput(
        $differenceEngine, $out, $parserOutput, $wikiPage
    );
}
