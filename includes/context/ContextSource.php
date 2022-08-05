<?php
/**
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
 * @author Happy-melon
 * @file
 */

use MediaWiki\MediaWikiServices;
use MediaWiki\Permissions\Authority;
use MediaWiki\Session\CsrfTokenSet;
use Wikimedia\NonSerializable\NonSerializableTrait;

/**
 * The simplest way of implementing IContextSource is to hold a RequestContext as a
 * member variable and provide accessors to it.
 *
 * @stable to extend
 * @since 1.18
 */
abstract class ContextSource implements IContextSource
{
    use NonSerializableTrait;

    /**
     * @var IContextSource
     */
    private $context;

    /**
     * Get the base IContextSource object
     * @return IContextSource
     * @since 1.18
     * @stable to override
     */
    public function getContext()
    {
        if ($this->context === null) {
            $class = static::class;
            wfDebug(__METHOD__ . " ($class): called and \$context is null. " .
                "Using RequestContext::getMain()");
            $this->context = RequestContext::getMain();
        }

        return $this->context;
    }

    /**
     * @param IContextSource $context
     * @since 1.18
     * @stable to override
     */
    public function setContext(IContextSource $context)
    {
        $this->context = $context;
    }

    /**
     * @return Config
     * @since 1.23
     * @stable to override
     */
    public function getConfig()
    {
        return $this->getContext()->getConfig();
    }

    /**
     * @return WebRequest
     * @since 1.18
     * @stable to override
     */
    public function getRequest()
    {
        return $this->getContext()->getRequest();
    }

    /**
     * @return Title|null
     * @since 1.18
     * @stable to override
     */
    public function getTitle()
    {
        return $this->getContext()->getTitle();
    }

    /**
     * Check whether a WikiPage object can be get with getWikiPage().
     * Callers should expect that an exception is thrown from getWikiPage()
     * if this method returns false.
     *
     * @return bool
     * @since 1.19
     * @stable to override
     */
    public function canUseWikiPage()
    {
        return $this->getContext()->canUseWikiPage();
    }

    /**
     * Get the WikiPage object.
     * May throw an exception if there's no Title object set or the Title object
     * belongs to a special namespace that doesn't have WikiPage, so use first
     * canUseWikiPage() to check whether this method can be called safely.
     *
     * @return WikiPage
     * @since 1.19
     * @stable to override
     */
    public function getWikiPage()
    {
        return $this->getContext()->getWikiPage();
    }

    /**
     * Get the action name for the current web request.
     *
     * @return string
     * @since 1.38
     * @stable to override
     */
    public function getActionName(): string
    {
        return $this->getContext()->getActionName();
    }

    /**
     * @return OutputPage
     * @since 1.18
     * @stable to override
     */
    public function getOutput()
    {
        return $this->getContext()->getOutput();
    }

    /**
     * @stable to override
     * @return User
     * @since 1.18
     * @stable to override
     */
    public function getUser()
    {
        return $this->getContext()->getUser();
    }

    /**
     * @return Authority
     * @since 1.36
     */
    public function getAuthority(): Authority
    {
        return $this->getContext()->getAuthority();
    }

    /**
     * @return Language
     * @since 1.19
     * @stable to override
     */
    public function getLanguage()
    {
        return $this->getContext()->getLanguage();
    }

    /**
     * @return Skin
     * @since 1.18
     * @stable to override
     */
    public function getSkin()
    {
        return $this->getContext()->getSkin();
    }

    /**
     * @return Timing
     * @since 1.27
     * @stable to override
     */
    public function getTiming()
    {
        return $this->getContext()->getTiming();
    }

    /**
     * @return IBufferingStatsdDataFactory
     * @since 1.25
     * @deprecated since 1.27 use a StatsdDataFactory from MediaWikiServices (preferably injected).
     *  Hard deprecated since 1.39.
     *
     */
    public function getStats()
    {
        wfDeprecated(__METHOD__, '1.27');

        return MediaWikiServices::getInstance()->getStatsdDataFactory();
    }

    /**
     * Get a Message object with context set
     * Parameters are the same as wfMessage()
     *
     * @param string|string[]|MessageSpecifier $key Message key, or array of keys,
     *   or a MessageSpecifier.
     * @param mixed ...$params
     * @return Message
     * @since 1.18
     * @stable to override
     */
    public function msg($key, ...$params)
    {
        return $this->getContext()->msg($key, ...$params);
    }

    /**
     * Export the resolved user IP, HTTP headers, user ID, and session ID.
     * The result will be reasonably sized to allow for serialization.
     *
     * @return array
     * @since 1.21
     * @stable to override
     */
    public function exportSession()
    {
        return $this->getContext()->exportSession();
    }

    /**
     * Get a repository to obtain and match CSRF tokens.
     *
     * @return CsrfTokenSet
     * @since 1.37
     */
    public function getCsrfTokenSet(): CsrfTokenSet
    {
        return $this->getContext()->getCsrfTokenSet();
    }
}
