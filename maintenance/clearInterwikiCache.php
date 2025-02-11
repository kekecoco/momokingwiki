<?php
/**
 * Clear the cache of interwiki prefixes for all local wikis.
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

use MediaWiki\MainConfigNames;

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script to clear the cache of interwiki prefixes for all local wikis.
 *
 * @ingroup Maintenance
 */
class ClearInterwikiCache extends Maintenance
{

    public function __construct()
    {
        parent::__construct();
        $this->addDescription('Clear all interwiki links for all languages from the cache');
    }

    public function execute()
    {
        $dbr = $this->getDB(DB_REPLICA);
        $cache = ObjectCache::getLocalClusterInstance();
        $res = $dbr->newSelectQueryBuilder()
            ->select('iw_prefix')
            ->from('interwiki')
            ->caller(__METHOD__)
            ->fetchResultSet();
        $prefixes = [];
        foreach ($res as $row) {
            $prefixes[] = $row->iw_prefix;
        }

        foreach ($this->getConfig()->get(MainConfigNames::LocalDatabases) as $wikiId) {
            $this->output("$wikiId...");
            foreach ($prefixes as $prefix) {
                $cache->delete("$wikiId:interwiki:$prefix");
            }
            $this->output("done\n");
        }
    }
}

$maintClass = ClearInterwikiCache::class;
require_once RUN_MAINTENANCE_IF_MAIN;
