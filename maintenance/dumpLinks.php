<?php
/**
 * Quick demo hack to generate a plaintext link dump,
 * per the proposed wiki link database standard:
 * http://www.usemod.com/cgi-bin/mb.pl?LinkDatabase
 *
 * Includes all (live and broken) intra-wiki links.
 * Does not include interwiki or URL links.
 * Dumps ASCII text to stdout; command-line.
 *
 * Copyright © 2005 Brion Vibber <brion@pobox.com>
 * https://www.mediawiki.org/
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

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script that generates a plaintext link dump.
 *
 * @ingroup Maintenance
 */
class DumpLinks extends Maintenance
{
    public function __construct()
    {
        parent::__construct();
        $this->addDescription('Quick demo hack to generate a plaintext link dump');
    }

    public function execute()
    {
        $dbr = $this->getDB(DB_REPLICA);

        $result = $dbr->newSelectQueryBuilder()
            ->select([
                'page_id',
                'page_namespace',
                'page_title',
                'pl_namespace',
                'pl_title'
            ])
            ->from('page')
            ->join('pagelinks', null, ['page_id=pl_from'])
            ->orderBy('page_id')
            ->caller(__METHOD__)
            ->fetchResultSet();

        $lastPage = null;
        foreach ($result as $row) {
            if ($lastPage != $row->page_id) {
                if ($lastPage !== null) {
                    $this->output("\n");
                }
                $page = Title::makeTitle($row->page_namespace, $row->page_title);
                $this->output($page->getPrefixedURL());
                $lastPage = $row->page_id;
            }
            $link = Title::makeTitle($row->pl_namespace, $row->pl_title);
            $this->output(" " . $link->getPrefixedURL());
        }
        if ($lastPage !== null) {
            $this->output("\n");
        }
    }
}

$maintClass = DumpLinks::class;
require_once RUN_MAINTENANCE_IF_MAIN;
