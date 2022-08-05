<?php
/**
 * Block restriction interface.
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

namespace MediaWiki\Block\Restriction;

interface Restriction
{

    /**
     * Gets the id of the block.
     *
     * @return int
     * @since 1.33
     */
    public function getBlockId();

    /**
     * Sets the id of the block.
     *
     * @param int $blockId
     * @return self
     * @since 1.33
     */
    public function setBlockId($blockId);

    /**
     * Gets the value of the restriction.
     *
     * @return int
     * @since 1.33
     */
    public function getValue();

    /**
     * Gets the type of restriction
     *
     * @return string
     * @since 1.33
     */
    public static function getType();

    /**
     * Gets the id of the type of restriction. This id is used in the database.
     *
     * @return int
     * @since 1.33
     */
    public static function getTypeId();

    /**
     * Creates a new Restriction from a database row.
     *
     * @param \stdClass $row
     * @return static
     * @since 1.33
     */
    public static function newFromRow(\stdClass $row);

    /**
     * Convert a restriction object into a row array for insertion.
     *
     * @return array
     * @since 1.33
     */
    public function toRow();

    /**
     * Determine if a restriction matches a given title.
     *
     * @param \Title $title
     * @return bool
     * @since 1.33
     */
    public function matches(\Title $title);

    /**
     * Determine if a restriction equals another restriction.
     *
     * @param Restriction $other
     * @return bool
     * @since 1.33
     */
    public function equals(Restriction $other);

    /**
     * Create a unique hash of the block restriction based on the type and value.
     *
     * @return string
     * @since 1.33
     */
    public function getHash();

}
