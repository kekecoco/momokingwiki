<?php

use MediaWiki\Content\Renderer\ContentParseParams;

class DummyContentHandlerForTesting extends ContentHandler
{

    public function __construct($dataModel, $formats = [DummyContentForTesting::MODEL_ID])
    {
        parent::__construct($dataModel, $formats);
    }

    protected function getContentClass()
    {
        return DummyContentForTesting::class;
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
        return new DummyContentForTesting($blob);
    }

    /**
     * Creates an empty Content object of the type supported by this ContentHandler.
     * @return DummyContentForTesting
     */
    public function makeEmptyContent()
    {
        return new DummyContentForTesting('');
    }

    public function generateHTMLOnEdit(): bool
    {
        return false;
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
        '@phan-var DummyContentForTesting $content';
        $output = new ParserOutput($content->getNativeData());
    }
}
