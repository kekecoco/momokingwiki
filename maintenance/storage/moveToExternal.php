<?php
/**
 * Move revision's text to external storage
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
 * @ingroup Maintenance ExternalStorage
 */

// NO_AUTOLOAD -- file scope code

use MediaWiki\MediaWikiServices;

define('REPORTING_INTERVAL', 1);

if (!defined('MEDIAWIKI')) {
    $optionsWithArgs = ['e', 's'];
    require_once __DIR__ . '/../CommandLineInc.php';
    require_once 'resolveStubs.php';

    $fname = 'moveToExternal';

    if (!isset($args[1])) {
        print "Usage: php moveToExternal.php [-s <startid>] [-e <endid>] <type> <location>\n";
        exit;
    }

    $type = $args[0]; // e.g. "DB" or "mwstore"
    $location = $args[1]; // e.g. "cluster12" or "global-swift"
    $dbw = wfGetDB(DB_PRIMARY);

    $maxID = (int)($options['e'] ?? $dbw->selectField('text', 'MAX(old_id)', '', $fname));
    $minID = (int)($options['s'] ?? 1);

    moveToExternal($type, $location, $maxID, $minID);
}

function moveToExternal($type, $location, $maxID, $minID = 1)
{
    $fname = 'moveToExternal';
    $dbw = wfGetDB(DB_PRIMARY);
    $dbr = wfGetDB(DB_REPLICA);

    $count = $maxID - $minID + 1;
    $blockSize = 1000;
    $numBlocks = ceil($count / $blockSize);
    print "Moving text rows from $minID to $maxID to external storage\n";

    $esFactory = MediaWikiServices::getInstance()->getExternalStoreFactory();
    $lbFactory = MediaWikiServices::getInstance()->getDBLoadBalancerFactory();
    $extStore = $esFactory->getStore($type);
    $numMoved = 0;

    for ($block = 0; $block < $numBlocks; $block++) {
        $blockStart = $block * $blockSize + $minID;
        $blockEnd = $blockStart + $blockSize - 1;

        if (!($block % REPORTING_INTERVAL)) {
            print "oldid=$blockStart, moved=$numMoved\n";
            $lbFactory->waitForReplication();
        }

        $res = $dbr->select('text', ['old_id', 'old_flags', 'old_text'],
            [
                "old_id BETWEEN $blockStart AND $blockEnd",
                'old_flags NOT ' . $dbr->buildLike($dbr->anyString(), 'external', $dbr->anyString()),
            ], $fname
        );
        foreach ($res as $row) {
            # Resolve stubs
            $text = $row->old_text;
            $id = $row->old_id;
            if ($row->old_flags === '') {
                $flags = 'external';
            } else {
                $flags = "{$row->old_flags},external";
            }

            if (strpos($flags, 'object') !== false) {
                $obj = unserialize($text);
                $className = strtolower(get_class($obj));
                if ($className == 'historyblobstub') {
                    # resolveStub( $id, $row->old_text, $row->old_flags );
                    # $numStubs++;
                    continue;
                } elseif ($className == 'historyblobcurstub') {
                    $text = gzdeflate($obj->getText());
                    $flags = 'utf-8,gzip,external';
                } elseif ($className == 'concatenatedgziphistoryblob') {
                    // Do nothing
                } else {
                    print "Warning: unrecognised object class \"$className\"\n";
                    continue;
                }
            } else {
                $className = false;
            }

            if (strlen($text) < 100 && $className === false) {
                // Don't move tiny revisions
                continue;
            }

            # print "Storing "  . strlen( $text ) . " bytes to $url\n";
            # print "old_id=$id\n";

            $url = $extStore->store($location, $text);
            if (!$url) {
                print "Error writing to external storage\n";
                exit;
            }
            $dbw->update('text',
                ['old_flags' => $flags, 'old_text' => $url],
                ['old_id' => $id], $fname);
            $numMoved++;
        }
    }
}
