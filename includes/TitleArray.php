<?php
/**
 * Class to walk into a list of Title objects.
 *
 * Note: this entire file is a byte-for-byte copy of UserArray.php with
 * s/User/Title/.  If anyone can figure out how to do this nicely with
 * inheritance or something, please do so.
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

use Wikimedia\Rdbms\IResultWrapper;

/**
 * The TitleArray class only exists to provide the newFromResult method at pre-
 * sent.
 * The documentation of the return types for the abstract current/key functions
 * helps static code analyzer to treat this as Iterator<Title>
 *
 * @method int count()
 */
abstract class TitleArray implements Iterator
{
    /**
     * @param IResultWrapper $res A SQL result including at least page_namespace and
     *   page_title -- also can have page_id, page_len, page_is_redirect,
     *   page_latest (if those will be used).  See Title::newFromRow.
     * @return TitleArrayFromResult
     */
    public static function newFromResult($res)
    {
        // TODO consider merging this class with TitleArrayFromResult now that the
        // TitleArrayFromResult hook has been removed
        return new TitleArrayFromResult($res);
    }

    /**
     * @return Title
     */
    abstract public function current(): Title;

    /**
     * @return int
     */
    abstract public function key(): int;
}
