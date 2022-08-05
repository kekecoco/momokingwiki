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
 * @ingroup Database
 */

namespace Wikimedia\Rdbms;

/**
 * Database connection manager.
 *
 * This manages access to primary and replica databases. It also manages state that indicates whether
 * the replica databases are possibly outdated after a write operation, and thus the primary database
 * should be used for subsequent read operations.
 *
 * @note: Services that access overlapping sets of database tables, or interact with logically
 * related sets of data in the database, should share a SessionConsistentConnectionManager.
 * Services accessing unrelated sets of information may prefer to not share a
 * SessionConsistentConnectionManager, so they can still perform read operations against replica
 * databases after a (unrelated, per the assumption) write operation to the primary database.
 * Generally, sharing a SessionConsistentConnectionManager improves consistency (by avoiding race
 * conditions due to replication lag), but can reduce performance (by directing more read
 * operations to the primary database server).
 *
 * @since 1.29
 *
 * @author Daniel Kinzler
 * @author Addshore
 */
class SessionConsistentConnectionManager extends ConnectionManager
{

    /**
     * @var bool
     */
    private $forceWriteConnection = false;

    /**
     * Forces all future calls to getReadConnection() to return a write connection.
     * Use this before performing read operations that are critical for a future update.
     *
     * @since 1.29
     */
    public function prepareForUpdates()
    {
        $this->forceWriteConnection = true;
    }

    /**
     * @param string[]|null $groups
     * @param int $flags
     *
     * @return IDatabase
     * @since 1.37 Added optional $flags parameter
     *
     * @since 1.29
     */
    public function getReadConnection(?array $groups = null, int $flags = 0)
    {
        if ($this->forceWriteConnection) {
            return parent::getWriteConnection($flags);
        }

        return parent::getReadConnection($groups, $flags);
    }

    /**
     * @param int $flags
     *
     * @return IDatabase
     * @since 1.29
     * @since 1.37 Added optional $flags parameter
     *
     */
    public function getWriteConnection(int $flags = 0)
    {
        $this->prepareForUpdates();

        return parent::getWriteConnection($flags);
    }

    /**
     * @param string[]|null $groups
     *
     * @return DBConnRef
     * @since 1.29
     *
     */
    public function getReadConnectionRef(array $groups = null)
    {
        if ($this->forceWriteConnection) {
            return parent::getWriteConnectionRef();
        }

        return parent::getReadConnectionRef($groups);
    }

    /**
     * @return DBConnRef
     * @since 1.29
     *
     */
    public function getWriteConnectionRef()
    {
        $this->prepareForUpdates();

        return parent::getWriteConnectionRef();
    }

}
