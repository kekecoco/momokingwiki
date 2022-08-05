<?php

use MediaWiki\Content\Renderer\ContentParseParams;

class DummyNonTextContentHandler extends DummyContentHandlerForTesting
{

    public function __construct($dataModel)
    {
        parent::__construct($dataModel, ["testing-nontext"]);
    }

    /**
     * @param Content $content
     * @param string|null $format
     *
     * @return string
     * @see ContentHandler::serializeContent
     *
     */
    public function serializeContent(Content $content, $format = null)
    {
        return $content->serialize();
    }

    /**
     * @param string $blob
     * @param string|null $format Unused.
     *
     * @return Content
     * @see ContentHandler::unserializeContent
     *
     */
    public function unserializeContent($blob, $format = null)
    {
        return new DummyNonTextContent($blob);
    }

    /**
     * Creates an empty Content object of the type supported by this ContentHandler.
     * @return DummyNonTextContent
     */
    public function makeEmptyContent()
    {
        return new DummyNonTextContent('');
    }

    public function supportsDirectApiEditing()
    {
        return true;
    }

    /**
     * @param Content $content
     * @param ContentParseParams $cpoParams
     * @param ParserOutput &$output The output object to fill (reference).
     * @since 1.38
     * @see ContentHandler::fillParserOutput()
     *
     */
    protected function fillParserOutput(
        Content $content,
        ContentParseParams $cpoParams,
        ParserOutput &$output
    )
    {
        '@phan-var DummyNonTextContent $content';
        $output = new ParserOutput($content->serialize());
    }
}
