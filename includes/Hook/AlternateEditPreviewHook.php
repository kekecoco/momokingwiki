<?php

namespace MediaWiki\Hook;

use Content;
use EditPage;
use ParserOutput;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "AlternateEditPreview" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface AlternateEditPreviewHook
{
    /**
     * This hook is called before generating the preview of the page when editing
     * ( EditPage::getPreviewText() ).
     *
     * @param EditPage $editPage
     * @param Content &$content Content object for the text field from the edit page
     * @param string &$previewHTML Text to be placed into the page for the preview
     * @param ParserOutput &$parserOutput ParserOutput object for the preview
     * @return bool|void True or no return value to continue, or false and set $previewHTML and
     *   $parserOutput to output custom page preview HTML
     * @since 1.35
     *
     */
    public function onAlternateEditPreview($editPage, &$content, &$previewHTML,
                                           &$parserOutput
    );
}
