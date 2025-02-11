<?php
/**
 * Implements Special:MyLanguage
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
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2010-2013 Niklas Laxström, Siebrand Mazeland
 */

use MediaWiki\Languages\LanguageNameUtils;
use MediaWiki\Page\RedirectLookup;

/**
 * Unlisted special page just to redirect the user to the translated version of
 * a page, if it exists.
 *
 * Usage: [[Special:MyLanguage/Page name|link text]]
 *
 * @since 1.24
 * @ingroup SpecialPage
 */
class SpecialMyLanguage extends RedirectSpecialArticle
{

    /** @var LanguageNameUtils */
    private $languageNameUtils;

    /** @var RedirectLookup */
    private $redirectLookup;

    /**
     * @param LanguageNameUtils $languageNameUtils
     * @param RedirectLookup $redirectLookup
     */
    public function __construct(
        LanguageNameUtils $languageNameUtils,
        RedirectLookup $redirectLookup
    )
    {
        parent::__construct('MyLanguage');
        $this->languageNameUtils = $languageNameUtils;
        $this->redirectLookup = $redirectLookup;
    }

    /**
     * If the special page is a redirect, then get the Title object it redirects to.
     * False otherwise.
     *
     * @param string|null $subpage
     * @return Title
     */
    public function getRedirect($subpage)
    {
        $title = $this->findTitle($subpage);
        // Go to the main page if given invalid title.
        if (!$title) {
            $title = Title::newMainPage();
        }

        return $title;
    }

    /**
     * Find a title. This may return the base page, e.g. if the UI and
     * content language are the same.
     *
     * Examples, assuming the UI language is fi and the content language
     * is en:
     * - input Page: returns Page/fi if it exists, otherwise Page
     * - input Page/de: returns Page/fi if it exists, otherwise Page/de
     * if it exists, otherwise Page
     *
     * @param string|null $subpage
     * @return Title|null
     */
    public function findTitle($subpage)
    {
        return $this->findTitleInternal($subpage, false);
    }

    /**
     * Find a title for transclusion. This avoids returning the base
     * page, if a suitable alternative exists.
     *
     * Examples, assuming the UI language is fi and the content language
     * is en:
     * - input Page: returns Page/fi if it exists, otherwise Page/en if
     * it exists, otherwise Page
     * - input Page/de: returns Page/fi if it exists, otherwise Page/de
     * if it exists, otherwise Page/en if it exists, otherwise Page
     *
     * @param string|null $subpage
     * @return Title|null
     */
    public function findTitleForTransclusion($subpage)
    {
        return $this->findTitleInternal($subpage, true);
    }

    /**
     * Find a title, depending on the content language and the user's
     * interface language.
     *
     * @param string|null $subpage
     * @param bool $forTransclusion
     * @return Title|null
     */
    private function findTitleInternal($subpage, $forTransclusion)
    {
        // base = title without language code suffix
        // provided = the title as it was given
        $base = $provided = null;
        if ($subpage !== null) {
            $provided = Title::newFromText($subpage);
            $base = $provided;

            if ($provided && strpos($subpage, '/') !== false) {
                $pos = strrpos($subpage, '/');
                $basepage = substr($subpage, 0, $pos);
                $code = substr($subpage, $pos + 1);
                if (strlen($code) && $this->languageNameUtils->isKnownLanguageTag($code)) {
                    $base = Title::newFromText($basepage);
                }
            }
        }

        if (!$base || !$base->canExist()) {
            // No subpage provided or base page does not exist
            return null;
        }

        if ($base->isRedirect()) {
            $base = $this->redirectLookup->getRedirectTarget($base);
        }

        $uiLang = $this->getLanguage();
        $contLang = $this->getContentLanguage();

        if ($uiLang->equals($contLang) && !$forTransclusion) {
            // Short circuit when the current UI language is the
            // wiki's default language to avoid unnecessary page lookups.
            return $base;
        }

        // Check for a subpage in current UI language
        $proposed = $base->getSubpage($uiLang->getCode());
        if ($proposed && $proposed->exists()) {
            return $proposed;
        }

        if ($provided !== $base && $provided->exists()) {
            // Explicit language code given and the page exists
            return $provided;
        }

        // Check for fallback languages specified by the UI language
        $possibilities = $uiLang->getFallbackLanguages();
        foreach ($possibilities as $lang) {
            if ($forTransclusion || $lang !== $contLang->getCode()) {
                $proposed = $base->getSubpage($lang);
                if ($proposed && $proposed->exists()) {
                    return $proposed;
                }
            }
        }

        // When all else has failed, return the base page
        return $base;
    }

    /**
     * Target can identify a specific user's language preference.
     *
     * @return bool
     * @since 1.27
     * @see T109724
     */
    public function personallyIdentifiableTarget()
    {
        return true;
    }
}
