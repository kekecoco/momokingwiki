<?php
/**
 * Wrapper content object allowing to handle a system message as a Content object.
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
 * @deprecated since 1.38.
 *
 * @file
 * @ingroup Content
 *
 * @author Daniel Kinzler
 */

/**
 * Wrapper allowing us to handle a system message as a Content object.
 * Note that this is generally *not* used to represent content from the
 * MediaWiki namespace.
 * MessageContent is just intended as glue for wrapping a message programmatically.
 *
 * @ingroup Content
 */
class MessageContent extends AbstractContent
{

    /**
     * @var Message
     */
    protected $mMessage;

    /**
     * @param Message|string $msg A Message object, or a message key.
     * @param string[]|null $params An optional array of message parameters.
     */
    public function __construct($msg, $params = null)
    {
        wfDeprecated(__CLASS__, '1.38');
        # XXX: messages may be wikitext, html or plain text! and maybe even something else entirely.
        parent::__construct(CONTENT_MODEL_WIKITEXT);

        if (is_string($msg)) {
            $this->mMessage = wfMessage($msg);
        } else {
            $this->mMessage = clone $msg;
        }

        if ($params) {
            $this->mMessage = $this->mMessage->params($params);
        }
    }

    /**
     * Returns the message text. {{-transformation is done.
     *
     * @return string Unescaped message text.
     */
    public function getWikitext()
    {
        return $this->mMessage->text();
    }

    /**
     * Returns the message object, with any parameters already substituted.
     *
     * @return Message
     * @deprecated since 1.33 use getMessage() instead.
     *
     */
    public function getNativeData()
    {
        return $this->getMessage();
    }

    /**
     * Returns the message object, with any parameters already substituted.
     *
     * @return Message
     * @since 1.33
     *
     */
    public function getMessage()
    {
        // NOTE: Message objects are mutable. Cloning here makes MessageContent immutable.
        return clone $this->mMessage;
    }

    /**
     * @return string
     *
     * @see Content::getTextForSearchIndex
     */
    public function getTextForSearchIndex()
    {
        return $this->mMessage->plain();
    }

    /**
     * @return string
     *
     * @see Content::getWikitextForTransclusion
     */
    public function getWikitextForTransclusion()
    {
        return $this->getWikitext();
    }

    /**
     * @param int $maxlength Maximum length of the summary text, defaults to 250.
     *
     * @return string The summary text.
     *
     * @see Content::getTextForSummary
     */
    public function getTextForSummary($maxlength = 250)
    {
        return $this->mMessage->getLanguage()->truncateForDatabase(
            $this->mMessage->plain(), $maxlength, '');
    }

    /**
     * @return int
     *
     * @see Content::getSize
     */
    public function getSize()
    {
        return strlen($this->mMessage->plain());
    }

    /**
     * @return Content A copy of this object
     *
     * @see Content::copy
     */
    public function copy()
    {
        // MessageContent is immutable (because getNativeData() and getMessage()
        //   returns a clone of the Message object)
        return $this;
    }

    /**
     * @param bool|null $hasLinks
     *
     * @return bool Always false.
     *
     * @see Content::isCountable
     */
    public function isCountable($hasLinks = null)
    {
        return false;
    }
}
