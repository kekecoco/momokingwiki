<?php
/**
 * OpenStack Swift based file backend.
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
 * @ingroup FileBackend
 * @author Russ Nelson
 */

/**
 * Iterator for listing directories
 */
class SwiftFileBackendDirList extends SwiftFileBackendList
{
    /**
     * @return string|bool String (relative path) or false
     * @see Iterator::current()
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return substr(current($this->bufferIter), $this->suffixStart, -1);
    }

    protected function pageFromList($container, $dir, &$after, $limit, array $params)
    {
        return $this->backend->getDirListPageInternal($container, $dir, $after, $limit, $params);
    }
}
