<?php
/**
 * Content handler for wiki text pages.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 1.21
 *
 * @file
 * @ingroup Content
 */

use MediaWiki\Content\Renderer\ContentParseParams;
use MediaWiki\Content\Transform\PreloadTransformParams;
use MediaWiki\Content\Transform\PreSaveTransformParams;
use MediaWiki\Languages\LanguageNameUtils;
use MediaWiki\MediaWikiServices;
use MediaWiki\Parser\ParserOutputFlags;

/**
 * Content handler for wiki text pages.
 *
 * @ingroup Content
 */
class WikitextContentHandler extends TextContentHandler
{

    public function __construct($modelId = CONTENT_MODEL_WIKITEXT)
    {
        parent::__construct($modelId, [CONTENT_FORMAT_WIKITEXT]);
    }

    protected function getContentClass()
    {
        return WikitextContent::class;
    }

    /**
     * Returns a WikitextContent object representing a redirect to the given destination page.
     *
     * @param Title $destination The page to redirect to.
     * @param string $text Text to include in the redirect, if possible.
     *
     * @return Content
     *
     * @see ContentHandler::makeRedirectContent
     */
    public function makeRedirectContent(Title $destination, $text = '')
    {
        $optionalColon = '';

        $services = MediaWikiServices::getInstance();
        if ($destination->getNamespace() === NS_CATEGORY) {
            $optionalColon = ':';
        } else {
            $iw = $destination->getInterwiki();
            if ($iw && $services
                    ->getLanguageNameUtils()
                    ->getLanguageName($iw,
                        LanguageNameUtils::AUTONYMS,
                        LanguageNameUtils::DEFINED)
            ) {
                $optionalColon = ':';
            }
        }

        $mwRedir = $services->getMagicWordFactory()->get('redirect');
        $redirectText = $mwRedir->getSynonym(0) .
            ' [[' . $optionalColon . $destination->getFullText() . ']]';

        if ($text != '') {
            $redirectText .= "\n" . $text;
        }

        $class = $this->getContentClass();

        return new $class($redirectText);
    }

    /**
     * Returns true because wikitext supports redirects.
     *
     * @return bool Always true.
     *
     * @see ContentHandler::supportsRedirects
     */
    public function supportsRedirects()
    {
        return true;
    }

    /**
     * Returns true because wikitext supports sections.
     *
     * @return bool Always true.
     *
     * @see ContentHandler::supportsSections
     */
    public function supportsSections()
    {
        return true;
    }

    /**
     * Returns true, because wikitext supports caching using the
     * ParserCache mechanism.
     *
     * @return bool Always true.
     *
     * @since 1.21
     *
     * @see ContentHandler::isParserCacheSupported
     */
    public function isParserCacheSupported()
    {
        return true;
    }

    /** @inheritDoc */
    public function supportsPreloadContent(): bool
    {
        return true;
    }

    /**
     * @return FileContentHandler
     */
    protected function getFileHandler()
    {
        return new FileContentHandler();
    }

    public function getFieldsForSearchIndex(SearchEngine $engine)
    {
        $fields = parent::getFieldsForSearchIndex($engine);

        $fields['heading'] =
            $engine->makeSearchFieldMapping('heading', SearchIndexField::INDEX_TYPE_TEXT);
        $fields['heading']->setFlag(SearchIndexField::FLAG_SCORING);

        $fields['auxiliary_text'] =
            $engine->makeSearchFieldMapping('auxiliary_text', SearchIndexField::INDEX_TYPE_TEXT);

        $fields['opening_text'] =
            $engine->makeSearchFieldMapping('opening_text', SearchIndexField::INDEX_TYPE_TEXT);
        $fields['opening_text']->setFlag(
            SearchIndexField::FLAG_SCORING | SearchIndexField::FLAG_NO_HIGHLIGHT
        );
        // Until we have full first-class content handler for files, we invoke it explicitly here
        $fields = array_merge($fields, $this->getFileHandler()->getFieldsForSearchIndex($engine));

        return $fields;
    }

    public function getDataForSearchIndex(
        WikiPage $page,
        ParserOutput $parserOutput,
        SearchEngine $engine
    )
    {
        $fields = parent::getDataForSearchIndex($page, $parserOutput, $engine);

        $structure = new WikiTextStructure($parserOutput);
        $fields['heading'] = $structure->headings();
        // text fields
        $fields['opening_text'] = $structure->getOpeningText();
        $fields['text'] = $structure->getMainText(); // overwrites one from ContentHandler
        $fields['auxiliary_text'] = $structure->getAuxiliaryText();
        $fields['defaultsort'] = $structure->getDefaultSort();

        // Until we have full first-class content handler for files, we invoke it explicitly here
        if ($page->getTitle()->getNamespace() === NS_FILE) {
            $fields = array_merge($fields,
                $this->getFileHandler()->getDataForSearchIndex($page, $parserOutput, $engine));
        }

        return $fields;
    }

    /**
     * Returns the content's text as-is.
     *
     * @param Content $content
     * @param string|null $format The serialization format to check
     *
     * @return mixed
     */
    public function serializeContent(Content $content, $format = null)
    {
        $this->checkFormat($format);

        // NOTE: MessageContent also uses CONTENT_MODEL_WIKITEXT, but it's not a TextContent!
        // Perhaps MessageContent should use a separate ContentHandler instead.
        if ($content instanceof MessageContent) {
            return $content->getMessage()->plain();
        }

        return parent::serializeContent($content, $format);
    }

    public function preSaveTransform(
        Content $content,
        PreSaveTransformParams $pstParams
    ): Content
    {
        $shouldCallDeprecatedMethod = $this->shouldCallDeprecatedContentTransformMethod(
            $content,
            $pstParams
        );

        if ($shouldCallDeprecatedMethod) {
            return $this->callDeprecatedContentPST(
                $content,
                $pstParams
            );
        }

        '@phan-var WikitextContent $content';

        $text = $content->getText();

        $parser = MediaWikiServices::getInstance()->getParserFactory()->getInstance();
        $pst = $parser->preSaveTransform(
            $text,
            $pstParams->getPage(),
            $pstParams->getUser(),
            $pstParams->getParserOptions()
        );

        if ($text === $pst) {
            return $content;
        }

        $contentClass = $this->getContentClass();
        $ret = new $contentClass($pst);
        $ret->setPreSaveTransformFlags($parser->getOutput()->getAllFlags());

        return $ret;
    }

    /**
     * Returns a Content object with preload transformations applied (or this
     * object if no transformations apply).
     *
     * @param Content $content
     * @param PreloadTransformParams $pltParams
     *
     * @return Content
     */
    public function preloadTransform(
        Content $content,
        PreloadTransformParams $pltParams
    ): Content
    {
        $shouldCallDeprecatedMethod = $this->shouldCallDeprecatedContentTransformMethod(
            $content,
            $pltParams
        );

        if ($shouldCallDeprecatedMethod) {
            return $this->callDeprecatedContentPLT(
                $content,
                $pltParams
            );
        }

        '@phan-var WikitextContent $content';

        $text = $content->getText();
        $plt = MediaWikiServices::getInstance()->getParserFactory()->getInstance()
            ->getPreloadText(
                $text,
                $pltParams->getPage(),
                $pltParams->getParserOptions(),
                $pltParams->getParams()
            );

        $contentClass = $this->getContentClass();

        return new $contentClass($plt);
    }

    /**
     * Returns a ParserOutput object resulting from parsing the content's text
     * using the global Parser service.
     *
     * @param Content $content
     * @param ContentParseParams $cpoParams
     * @param ParserOutput &$parserOutput The output object to fill (reference).
     * @since 1.38
     */
    protected function fillParserOutput(
        Content $content,
        ContentParseParams $cpoParams,
        ParserOutput &$parserOutput
    )
    {
        '@phan-var WikitextContent $content';
        $services = MediaWikiServices::getInstance();
        $title = $services->getTitleFactory()->castFromPageReference($cpoParams->getPage());
        $parserOptions = $cpoParams->getParserOptions();
        $revId = $cpoParams->getRevId();

        [$redir, $text] = $content->getRedirectTargetAndText();
        $parserOutput = $services->getParserFactory()->getInstance()
            // @phan-suppress-next-line PhanTypeMismatchArgumentNullable castFrom does not return null here
            ->parse($text, $title, $parserOptions, true, true, $revId);

        // Add redirect indicator at the top
        if ($redir) {
            // Make sure to include the redirect link in pagelinks
            $parserOutput->addLink($redir);
            if ($cpoParams->getGenerateHtml()) {
                $redirTarget = $content->getRedirectTarget();
                $parserOutput->setText(
                    Article::getRedirectHeaderHtml($title->getPageLanguage(), $redirTarget, false) .
                    $parserOutput->getRawText()
                );
                $parserOutput->addModuleStyles(['mediawiki.action.view.redirectPage']);
            } else {
                $parserOutput->setText(null);
            }
        }

        // Pass along user-signature flag
        if (in_array('user-signature', $content->getPreSaveTransformFlags())) {
            $parserOutput->setOutputFlag(ParserOutputFlags::USER_SIGNATURE);
        }
    }
}
