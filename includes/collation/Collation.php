<?php
/**
 * Database row sorting.
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

use MediaWiki\MainConfigNames;
use MediaWiki\MediaWikiServices;

/**
 * @since 1.16.3
 * @author Tim Starling
 * @stable to extend
 */
abstract class Collation
{
    private static $instance;

    /**
     * @return Collation
     * @since 1.16.3
     * @deprecated since 1.37 Use MediaWikiServices::getCollationFactory()->getCategoryCollation()
     */
    public static function singleton()
    {
        wfDeprecated(__METHOD__, '1.37');
        if (!self::$instance) {
            $categoryCollation = MediaWikiServices::getInstance()->getMainConfig()
                ->get(MainConfigNames::CategoryCollation);
            self::$instance = self::factory($categoryCollation);
        }

        return self::$instance;
    }

    /**
     * @param string $collationName
     * @return Collation
     * @throws MWException
     * @deprecated since 1.37 Use MediaWikiServices::getCollationFactory()->makeCollation()
     * @since 1.16.3
     */
    public static function factory($collationName)
    {
        wfDeprecated(__METHOD__, '1.37');

        return MediaWikiServices::getInstance()->getCollationFactory()->makeCollation($collationName);
    }

    /**
     * Given a string, convert it to a (hopefully short) key that can be used
     * for efficient sorting.  A binary sort according to the sortkeys
     * corresponds to a logical sort of the corresponding strings.  Current
     * code expects that a line feed character should sort before all others, but
     * has no other particular expectations (and that one can be changed if
     * necessary).
     *
     * @param string $string UTF-8 string
     * @return string Binary sortkey
     * @since 1.16.3
     *
     */
    abstract public function getSortKey($string);

    /**
     * Get multiple sort keys
     *
     * @param string[] $strings
     * @return string[]
     */
    public function getSortKeys($strings)
    {
        $ret = [];
        foreach ($strings as $key => $s) {
            $ret[$key] = $this->getSortKey($s);
        }

        return $ret;
    }

    /**
     * Given a string, return the logical "first letter" to be used for
     * grouping on category pages and so on.  This has to be coordinated
     * carefully with convertToSortkey(), or else the sorted list might jump
     * back and forth between the same "initial letters" or other pathological
     * behavior.  For instance, if you just return the first character, but "a"
     * sorts the same as "A" based on getSortKey(), then you might get a
     * list like
     *
     * == A ==
     * * [[Aardvark]]
     *
     * == a ==
     * * [[antelope]]
     *
     * == A ==
     * * [[Ape]]
     *
     * etc., assuming for the sake of argument that $wgCapitalLinks is false.
     *
     * @param string $string UTF-8 string
     * @return string UTF-8 string corresponding to the first letter of input
     * @since 1.16.3
     *
     */
    abstract public function getFirstLetter($string);

}
