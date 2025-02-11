<?php

namespace MediaWiki\Api\Hook;

use IContextSource;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiFormatHighlight" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiFormatHighlightHook
{
    /**
     * Use this hook to syntax-highlight API pretty-printed output.
     *
     * @param IContextSource $context
     * @param string $text Text to be highlighted
     * @param string $mime MIME type of $text
     * @param string $format API format code for $text
     * @return bool|void True or no return value to continue, or false and add output
     *  to $context->getOutput() to highlight
     * @since 1.35
     *
     */
    public function onApiFormatHighlight($context, $text, $mime, $format);
}
