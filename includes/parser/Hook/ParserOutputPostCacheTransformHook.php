<?php

namespace MediaWiki\Hook;

use ParserOutput;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserOutputPostCacheTransform" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserOutputPostCacheTransformHook
{
    /**
     * This hook is called from ParserOutput::getText() to do
     * post-cache transforms.
     *
     * @param ParserOutput $parserOutput
     * @param string &$text Text being transformed, before core transformations are done
     * @param array &$options Options array being used for the transformation
     * @return void This hook must not abort, it must return no value
     * @since 1.35
     *
     */
    public function onParserOutputPostCacheTransform($parserOutput, &$text,
                                                     &$options
    ): void;
}
