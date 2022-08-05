<?php
/**
 * Factory for creating Title objects without static coupling.
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
 */

use MediaWiki\Linker\LinkTarget;
use MediaWiki\Page\PageIdentity;
use MediaWiki\Page\PageReference;

/**
 * Creates Title objects.
 *
 * For now, there is nothing interesting in this class. It is meant for preventing static Title
 * methods causing problems in unit tests.
 *
 * @since 1.35
 */
class TitleFactory
{

    /**
     * @param string $key
     * @return Title|null
     * @see Title::newFromDBkey
     */
    public function newFromDBkey($key): ?Title
    {
        return Title::newFromDBkey($key);
    }

    /**
     * @param LinkTarget $linkTarget
     * @param string $forceClone
     * @return Title
     * @see Title::newFromLinkTarget
     */
    public function newFromLinkTarget(LinkTarget $linkTarget, $forceClone = ''): Title
    {
        return Title::newFromLinkTarget($linkTarget, $forceClone);
    }

    /**
     * @param LinkTarget|null $linkTarget
     * @return Title|null
     * @see Title::castFromLinkTarget
     */
    public function castFromLinkTarget(?LinkTarget $linkTarget): ?Title
    {
        return Title::castFromLinkTarget($linkTarget);
    }

    /**
     * @param PageIdentity|null $pageIdentity
     * @return Title|null
     * @see Title::castFromPageIdentity
     * @since 1.36
     */
    public function castFromPageIdentity(?PageIdentity $pageIdentity): ?Title
    {
        return Title::castFromPageIdentity($pageIdentity);
    }

    /**
     * @param PageReference|null $pageReference
     * @return Title|null
     * @see Title::castFromPageReference
     * @since 1.37
     */
    public function castFromPageReference(?PageReference $pageReference): ?Title
    {
        return Title::castFromPageReference($pageReference);
    }

    /**
     * @param string|int|null $text
     * @param int $defaultNamespace
     * @return Title|null
     * @throws InvalidArgumentException
     * @see Title::newFromText
     */
    public function newFromText($text, $defaultNamespace = NS_MAIN): ?Title
    {
        return Title::newFromText($text, $defaultNamespace);
    }

    /**
     * @param string $text
     * @param int $defaultNamespace
     * @return Title
     * @throws MalformedTitleException
     * @see Title::newFromTextThrow
     */
    public function newFromTextThrow($text, $defaultNamespace = NS_MAIN): Title
    {
        return Title::newFromTextThrow($text, $defaultNamespace);
    }

    /**
     * @param string $url
     * @return Title|null
     * @see Title::newFromURL
     */
    public function newFromURL($url): ?Title
    {
        return Title::newFromURL($url);
    }

    /**
     * @param int $id
     * @param int $flags
     * @return Title|null
     * @see Title::newFromID
     */
    public function newFromID($id, $flags = 0): ?Title
    {
        return Title::newFromID($id, $flags);
    }

    /**
     * @param int[] $ids
     * @return Title[]
     * @see Title::newFromIDs
     * @deprecated since 1.38 use a PageStore QueryBuilder instead
     */
    public function newFromIDs($ids): array
    {
        wfDeprecated(__METHOD__, '1.38');

        return Title::newFromIDs($ids);
    }

    /**
     * @param stdClass $row
     * @return Title
     * @see Title::newFromRow
     */
    public function newFromRow($row): Title
    {
        return Title::newFromRow($row);
    }

    /**
     * @param int $ns
     * @param string $title
     * @param string $fragment
     * @param string $interwiki
     * @return Title
     * @see Title::makeTitle
     */
    public function makeTitle($ns, $title, $fragment = '', $interwiki = ''): Title
    {
        return Title::makeTitle($ns, $title, $fragment, $interwiki);
    }

    /**
     * @param int $ns
     * @param string $title
     * @param string $fragment
     * @param string $interwiki
     * @return Title|null
     * @see Title::makeTitleSafe
     */
    public function makeTitleSafe($ns, $title, $fragment = '', $interwiki = ''): ?Title
    {
        return Title::makeTitleSafe($ns, $title, $fragment, $interwiki);
    }

    /**
     * @param MessageLocalizer|null $localizer
     * @return Title
     * @see Title::newMainPage
     */
    public function newMainPage(MessageLocalizer $localizer = null): Title
    {
        return Title::newMainPage($localizer);
    }

}
