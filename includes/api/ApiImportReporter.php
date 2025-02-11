<?php
/**
 * Copyright © 2009 Roan Kattouw "<Firstname>.<Lastname>@gmail.com"
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

use MediaWiki\MediaWikiServices;
use MediaWiki\Page\PageIdentity;

/**
 * Import reporter for the API
 * @ingroup API
 */
class ApiImportReporter extends ImportReporter
{
    private $mResultArr = [];

    /**
     * @param ?PageIdentity $pageIdentity
     * @param ForeignTitle $foreignTitle
     * @param int $revisionCount
     * @param int $successCount
     * @param array $pageInfo
     * @return void
     */
    public function reportPage(?PageIdentity $pageIdentity, $foreignTitle, $revisionCount, $successCount, $pageInfo)
    {
        // Add a result entry
        $r = [];

        if ($pageIdentity === null) {
            # Invalid or non-importable title
            $r['title'] = $pageInfo['title'];
            $r['invalid'] = true;
        } else {
            $titleFactory = MediaWikiServices::getInstance()->getTitleFactory();
            // @phan-suppress-next-line PhanTypeMismatchArgumentNullable castFrom does not return null here
            ApiQueryBase::addTitleInfo($r, $titleFactory->castFromPageIdentity($pageIdentity));
            $r['revisions'] = (int)$successCount;
        }

        $this->mResultArr[] = $r;

        // Piggyback on the parent to do the logging
        parent::reportPage($pageIdentity, $foreignTitle, $revisionCount, $successCount, $pageInfo);
    }

    public function getData()
    {
        return $this->mResultArr;
    }
}
