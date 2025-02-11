<?php
/**
 * A content object represents page content, e.g. the text to show on a page.
 * Content objects have no knowledge about how they relate to wiki pages.
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
 *
 * @author Daniel Kinzler
 */

/**
 * Base interface for content objects.
 *
 * @ingroup Content
 * @unstable for implementation, extensions should extend AbstractContent instead.
 */
interface Content
{

    /**
     * @return string A string representing the content in a way useful for
     *   building a full text search index. If no useful representation exists,
     *   this method returns an empty string.
     *
     * @since 1.21
     *
     * @todo Test that this actually works
     * @todo Make sure this also works with LuceneSearch / WikiSearch
     */
    public function getTextForSearchIndex();

    /**
     * @return string|bool The wikitext to include when another page includes this
     * content, or false if the content is not includable in a wikitext page.
     *
     * @since 1.21
     *
     * @todo Allow native handling, bypassing wikitext representation, like
     *  for includable special pages.
     * @todo Allow transclusion into other content models than Wikitext!
     * @todo Used in WikiPage and MessageCache to get message text. Not so
     *  nice. What should we use instead?!
     */
    public function getWikitextForTransclusion();

    /**
     * Returns a textual representation of the content suitable for use in edit
     * summaries and log messages.
     *
     * @param int $maxLength Maximum length of the summary text, in bytes.
     * Usually implemented using {@link Language::truncateForDatabase()}.
     *
     * @return string The summary text.
     * @since 1.21
     *
     */
    public function getTextForSummary($maxLength = 250);

    /**
     * Returns native representation of the data. Interpretation depends on
     * the data model used, as given by getDataModel().
     *
     * @return mixed The native representation of the content. Could be a
     *    string, a nested array structure, an object, a binary blob...
     *    anything, really.
     *
     * @note Caller must be aware of content model!
     * @deprecated since 1.33 use getText() for TextContent instances.
     *             For other content models, use specialized getters.
     *
     * @since 1.21
     *
     */
    public function getNativeData();

    /**
     * Returns the content's nominal size in "bogo-bytes".
     *
     * @return int
     */
    public function getSize();

    /**
     * Returns the ID of the content model used by this Content object.
     * Corresponds to the CONTENT_MODEL_XXX constants.
     *
     * @return string The model id
     * @since 1.21
     *
     */
    public function getModel();

    /**
     * Convenience method that returns the ContentHandler singleton for handling
     * the content model that this Content object uses.
     *
     * Shorthand for ContentHandler::getForContent( $this )
     *
     * @return ContentHandler
     * @since 1.21
     *
     */
    public function getContentHandler();

    /**
     * Convenience method that returns the default serialization format for the
     * content model that this Content object uses.
     *
     * Shorthand for $this->getContentHandler()->getDefaultFormat()
     *
     * @return string
     * @since 1.21
     *
     */
    public function getDefaultFormat();

    /**
     * Convenience method that returns the list of serialization formats
     * supported for the content model that this Content object uses.
     *
     * Shorthand for $this->getContentHandler()->getSupportedFormats()
     *
     * @return string[] List of supported serialization formats
     * @since 1.21
     *
     */
    public function getSupportedFormats();

    /**
     * Returns true if $format is a supported serialization format for this
     * Content object, false if it isn't.
     *
     * Note that this should always return true if $format is null, because null
     * stands for the default serialization.
     *
     * Shorthand for $this->getContentHandler()->isSupportedFormat( $format )
     *
     * @param string $format The serialization format to check.
     *
     * @return bool Whether the format is supported
     * @since 1.21
     *
     */
    public function isSupportedFormat($format);

    /**
     * Convenience method for serializing this Content object.
     *
     * Shorthand for $this->getContentHandler()->serializeContent( $this, $format )
     *
     * @param string|null $format The desired serialization format, or null for the default format.
     *
     * @return string Serialized form of this Content object.
     * @since 1.21
     *
     */
    public function serialize($format = null);

    /**
     * Returns true if this Content object represents empty content.
     *
     * @return bool Whether this Content object is empty
     * @since 1.21
     *
     */
    public function isEmpty();

    /**
     * Returns whether the content is valid. This is intended for local validity
     * checks, not considering global consistency.
     *
     * Content needs to be valid before it can be saved.
     *
     * This default implementation always returns true.
     *
     * @return bool
     * @since 1.21
     *
     */
    public function isValid();

    /**
     * Returns true if this Content objects is conceptually equivalent to the
     * given Content object.
     *
     * Contract:
     *
     * - Will return false if $that is null.
     * - Will return true if $that === $this.
     * - Will return false if $that->getModel() !== $this->getModel().
     * - Will return false if get_class( $that ) !== get_class( $this )
     * - Should return false if $that->getModel() == $this->getModel() and
     *     $that is not semantically equivalent to $this, according to
     *     the data model defined by $this->getModel().
     *
     * Implementations should be careful to make equals() transitive and reflexive:
     *
     * - $a->equals( $b ) <=> $b->equals( $a )
     * - $a->equals( $b ) &&  $b->equals( $c ) ==> $a->equals( $c )
     *
     * @param Content|null $that The Content object to compare to.
     *
     * @return bool True if this Content object is equal to $that, false otherwise.
     * @since 1.21
     *
     */
    public function equals(Content $that = null);

    /**
     * Return a copy of this Content object. The following must be true for the
     * object returned:
     *
     * if $copy = $original->copy()
     *
     * - get_class($original) === get_class($copy)
     * - $original->getModel() === $copy->getModel()
     * - $original->equals( $copy )
     *
     * If and only if the Content object is immutable, the copy() method can and
     * should return $this. That is, $copy === $original may be true, but only
     * for immutable content objects.
     *
     * @return Content A copy of this object
     * @since 1.21
     *
     */
    public function copy();

    /**
     * Returns true if this content is countable as a "real" wiki page, provided
     * that it's also in a countable location (e.g. a current revision in the
     * main namespace).
     *
     * @param bool|null $hasLinks If it is known whether this content contains
     *    links, provide this information here, to avoid redundant parsing to
     *    find out.
     *
     * @return bool
     * @see SlotRoleHandler::supportsArticleCount
     *
     * @since 1.21
     *
     */
    public function isCountable($hasLinks = null);

    /**
     * Parse the Content object and generate a ParserOutput from the result.
     * $result->getText() can be used to obtain the generated HTML. If no HTML
     * is needed, $generateHtml can be set to false; in that case,
     * $result->getText() may return null.
     *
     * @note To control which options are used in the cache key for the
     *       generated parser output, implementations of this method
     *       may call ParserOutput::recordOption() on the output object.
     * @param Title $title The page title to use as a context for rendering.
     * @param int|null $revId ID of the revision being rendered.
     *  See Parser::parse() for the ramifications. (default: null)
     * @param ParserOptions|null $options Any parser options.
     * @param bool $generateHtml Whether to generate HTML (default: true). If false,
     *        the result of calling getText() on the ParserOutput object returned by
     *        this method is undefined.
     *
     * @return ParserOutput
     * @since 1.21
     *
     * @deprecated since 1.38. Hard-deprecated since 1.38. Use ContentRenderer::getParserOutput
     * and override ContentHandler::fillParserOutput.
     */
    public function getParserOutput(Title $title, $revId = null,
                                    ParserOptions $options = null, $generateHtml = true);

    // TODO: make RenderOutput and RenderOptions base classes

    /**
     * Construct the redirect destination from this content and return a Title,
     * or null if this content doesn't represent a redirect.
     *
     * @return Title|null
     * @since 1.21
     *
     */
    public function getRedirectTarget();

    /**
     * Returns whether this Content represents a redirect.
     * Shorthand for getRedirectTarget() !== null.
     *
     * @return bool
     * @since 1.21
     *
     * @see SlotRoleHandler::supportsRedirects
     *
     */
    public function isRedirect();

    /**
     * If this Content object is a redirect, this method updates the redirect target.
     * Otherwise, it does nothing.
     *
     * @param Title $target The new redirect target
     *
     * @return Content A new Content object with the updated redirect (or $this
     *   if this Content object isn't a redirect)
     * @since 1.21
     *
     */
    public function updateRedirect(Title $target);

    /**
     * Returns the section with the given ID.
     *
     * @param string|int $sectionId Section identifier as a number or string
     * (e.g. 0, 1 or 'T-1'). The ID "0" retrieves the section before the first heading, "1" the
     * text between the first heading (included) and the second heading (excluded), etc.
     *
     * @return Content|bool|null The section, or false if no such section
     *    exist, or null if sections are not supported.
     * @since 1.21
     *
     */
    public function getSection($sectionId);

    /**
     * Replaces a section of the content and returns a Content object with the
     * section replaced.
     *
     * @param string|int|null|bool $sectionId Section identifier as a number or string
     * (e.g. 0, 1 or 'T-1'), null/false or an empty string for the whole page
     * or 'new' for a new section.
     * @param Content $with New content of the section
     * @param string $sectionTitle New section's subject, only if $section is 'new'
     *
     * @return Content|null New content of the entire page, or null if error
     * @since 1.21
     *
     */
    public function replaceSection($sectionId, Content $with, $sectionTitle = '');

    /**
     * Returns a Content object with pre-save transformations applied (or this
     * object if no transformations apply).
     *
     * @param Title $title
     * @param User $user
     * @param ParserOptions $parserOptions
     *
     * @return Content
     * @since 1.21
     * @deprecated since 1.37. Hard-deprecated since 1.37. Use ContentTransformer::preSaveTransform
     * and override ContentHandler::preSaveTransform.
     */
    public function preSaveTransform(Title $title, User $user, ParserOptions $parserOptions);

    /**
     * Returns a new WikitextContent object with the given section heading
     * prepended, if supported. The default implementation just returns this
     * Content object unmodified, ignoring the section header.
     *
     * @param string $header
     *
     * @return Content
     * @since 1.21
     *
     */
    public function addSectionHeader($header);

    /**
     * Returns a Content object with preload transformations applied (or this
     * object if no transformations apply).
     *
     * @param Title $title
     * @param ParserOptions $parserOptions
     * @param array $params
     *
     * @return Content
     * @since 1.21
     * @deprecated since 1.37. Hard-deprecated since 1.37. Use ContentTransformer::preloadTransform
     * and override ContentHandler::preloadTransform.
     */
    public function preloadTransform(Title $title, ParserOptions $parserOptions, $params = []);

    /**
     * Prepare Content for saving. Called before Content is saved by WikiPage::doUserEditContent() and in
     * similar places.
     *
     * This may be used to check the content's consistency with global state. This function should
     * NOT write any information to the database.
     *
     * Note that this method will usually be called inside the same transaction
     * bracket that will be used to save the new revision.
     *
     * Note that this method is called before any update to the page table is
     * performed. This means that $page may not yet know a page ID.
     *
     * @param WikiPage $page The page to be saved.
     * @param int $flags Bitfield for use with EDIT_XXX constants, see WikiPage::doUserEditContent()
     * @param int $parentRevId The ID of the current revision
     * @param User $user
     *
     * @return Status A status object indicating whether the content was
     *   successfully prepared for saving. If the returned status indicates
     *   an error, a rollback will be performed and the transaction aborted.
     *
     * @deprecated since 1.38. Hard-deprecated since 1.38. Use ContentHandler::validateSave instead.
     *
     * @since 1.21
     * @see WikiPage::doUserEditContent()
     */
    public function prepareSave(WikiPage $page, $flags, $parentRevId, User $user);

    /**
     * Returns true if this Content object matches the given magic word.
     *
     * @param MagicWord $word The magic word to match
     *
     * @return bool Whether this Content object matches the given magic word.
     * @since 1.21
     *
     */
    public function matchMagicWord(MagicWord $word);

    /**
     * Converts this content object into another content object with the given content model,
     * if that is possible.
     *
     * @param string $toModel The desired content model, use the CONTENT_MODEL_XXX flags.
     * @param string $lossy Optional flag, set to "lossy" to allow lossy conversion. If lossy
     * conversion is not allowed, full round-trip conversion is expected to work without losing
     * information.
     *
     * @return Content|bool A content object with the content model $toModel, or false if
     * that conversion is not supported.
     */
    public function convert($toModel, $lossy = '');

    // @todo ImagePage and CategoryPage interfere with per-content action handlers
    // @todo nice integration of GeSHi syntax highlighting
    //   [11:59] <vvv> Hooks are ugly; make CodeHighlighter interface and a
    //   config to set the class which handles syntax highlighting
    //   [12:00] <vvv> And default it to a DummyHighlighter

}
