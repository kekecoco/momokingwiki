<?php
/**
 * Show page contents.
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
 * @ingroup Maintenance
 */

use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\RevisionRecord;

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script to show page contents.
 *
 * @ingroup Maintenance
 */
class ViewCLI extends Maintenance
{
    public function __construct()
    {
        parent::__construct();
        $this->addDescription('Show article contents on the command line');
        $this->addArg('title', 'Title of article to view');
    }

    public function execute()
    {
        $title = Title::newFromText($this->getArg(0));
        if (!$title) {
            $this->fatalError("Invalid title");
        } elseif ($title->isSpecialPage()) {
            $this->fatalError("Special Pages not supported");
        } elseif (!$title->exists()) {
            $this->fatalError("Page does not exist");
        }

        $page = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle($title);

        $content = $page->getContent(RevisionRecord::RAW);
        if (!$content) {
            $this->fatalError("Page has no content");
        }
        if (!$content instanceof TextContent) {
            $this->fatalError("Non-text content models not supported");
        }

        $this->output($content->getText());
    }
}

$maintClass = ViewCLI::class;
require_once RUN_MAINTENANCE_IF_MAIN;
