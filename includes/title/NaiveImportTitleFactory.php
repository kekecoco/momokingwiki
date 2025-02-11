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
 * @file
 */

/**
 * A class to convert page titles on a foreign wiki (ForeignTitle objects) into
 * page titles on the local wiki (Title objects), using a default namespace
 * mapping.
 *
 * For built-in namespaces (0 <= ID < 100), we try to find a local namespace
 * with the same namespace ID as the foreign page. If no such namespace exists,
 * or the namespace ID is unknown or > 100, we look for a local namespace with
 * a matching namespace name. If that can't be found, we dump the page in the
 * main namespace as a last resort.
 */
class NaiveImportTitleFactory implements ImportTitleFactory
{
    /** @var Language */
    private $contentLanguage;

    /** @var NamespaceInfo */
    private $namespaceInfo;

    /** @var TitleFactory */
    private $titleFactory;

    /**
     * @param Language $contentLanguage
     * @param NamespaceInfo $namespaceInfo
     * @param TitleFactory $titleFactory
     */
    public function __construct(
        Language $contentLanguage,
        NamespaceInfo $namespaceInfo,
        TitleFactory $titleFactory
    )
    {
        $this->contentLanguage = $contentLanguage;
        $this->namespaceInfo = $namespaceInfo;
        $this->titleFactory = $titleFactory;
    }

    /**
     * Determines which local title best corresponds to the given foreign title.
     * If such a title can't be found or would be locally invalid, null is
     * returned.
     *
     * @param ForeignTitle $foreignTitle The ForeignTitle to convert
     * @return Title|null
     */
    public function createTitleFromForeignTitle(ForeignTitle $foreignTitle)
    {
        if ($foreignTitle->isNamespaceIdKnown()) {
            $foreignNs = $foreignTitle->getNamespaceId();

            // For built-in namespaces (0 <= ID < 100), we try to find a local NS with
            // the same namespace ID
            if (
                $foreignNs < 100 &&
                $this->namespaceInfo->exists($foreignNs)
            ) {
                return $this->titleFactory->makeTitleSafe($foreignNs, $foreignTitle->getText());
            }
        }

        // Do we have a local namespace by the same name as the foreign
        // namespace?
        $targetNs = $this->contentLanguage->getNsIndex($foreignTitle->getNamespaceName());
        if ($targetNs !== false) {
            return $this->titleFactory->makeTitleSafe($targetNs, $foreignTitle->getText());
        }

        // Otherwise, just fall back to main namespace
        return $this->titleFactory->makeTitleSafe(0, $foreignTitle->getFullText());
    }
}
