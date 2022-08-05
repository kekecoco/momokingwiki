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

use InvalidArgumentException;

/**
 * Database connection manager.
 *
 * This manages access to primary and replica databases.
 *
 * @since 1.29
 *
 * @author Addshore
 */
class ConnectionManager
{

    /**
     * @var ILoadBalancer
     */
    private $loadBalancer;

    /**
     * The symbolic name of the target database, or false for the local wiki's database.
     *
     * @var string|false
     */
    private $domain;

    /**
     * @var string[]
     */
    private $groups = [];

    /**
     * @param ILoadBalancer $loadBalancer
     * @param string|false $domain Optional logical DB name, defaults to current wiki.
     *        This follows the convention for database names used by $loadBalancer.
     * @param string[] $groups see LoadBalancer::getConnection
     *
     * @throws InvalidArgumentException
     */
    public function __construct(ILoadBalancer $loadBalancer, $domain = false, array $groups = [])
    {
        if (!is_string($domain) && $domain !== false) {
            throw new InvalidArgumentException('$dbName must be a string, or false.');
        }

        $this->loadBalancer = $loadBalancer;
        $this->domain = $domain;
        $this->groups = $groups;
    }

    /**
     * @param int $i
     * @param string[]|null $groups
     * @param int $flags
     * @return IDatabase
     */
    private function getConnection($i, ?array $groups = null, int $flags = 0)
    {
        $groups = $groups ?? $this->groups;

        return $this->loadBalancer->getConnection($i, $groups, $this->domain, $flags);
    }

    /**
     * @param int $i
     * @param string[]|null $groups
     * @return DBConnRef
     */
    private function getConnectionRef($i, array $groups = null)
    {
        $groups = $groups ?? $this->groups;

        return $this->loadBalancer->getConnectionRef($i, $groups, $this->domain);
    }

    /**
     * Returns a connection to the primary DB, for updating.
     *
     * @param int $flags
     * @return IDatabase
     * @since 1.29
     * @since 1.37 Added optional $flags parameter
     */
    public function getWriteConnection(int $flags = 0)
    {
        return $this->getConnection(DB_PRIMARY, null, $flags);
    }

    /**
     * Returns a database connection for reading.
     *
     * @param string[]|null $groups
     * @param int $flags
     * @return IDatabase
     * @since 1.37 Added optional $flags parameter
     * @since 1.29
     */
    public function getReadConnection(?array $groups = null, int $flags = 0)
    {
        $groups = $groups ?? $this->groups;

        return $this->getConnection(DB_REPLICA, $groups, $flags);
    }

    /**
     * @param IDatabase $db
     * @since 1.29
     * @deprecated since 1.38
     */
    public function releaseConnection(IDatabase $db)
    {
        $this->loadBalancer->reuseConnection($db);
    }

    /**
     * Returns a connection ref to the primary DB, for updating.
     *
     * @return DBConnRef
     * @since 1.29
     *
     * @deprecated since 1.39; Use getWriteConnection()
     */
    public function getWriteConnectionRef()
    {
        return $this->getConnectionRef(DB_PRIMARY);
    }

    /**
     * Returns a database connection ref for reading.
     *
     * @param string[]|null $groups
     * @return DBConnRef
     * @since 1.29
     * @deprecated since 1.38; Use getReadConnection()
     */
    public function getReadConnectionRef(array $groups = null)
    {
        $groups = $groups ?? $this->groups;

        return $this->getConnectionRef(DB_REPLICA, $groups);
    }

    /**
     * Returns a lazy-connecting database connection ref for updating.
     *
     * @return DBConnRef
     * @since 1.38
     * @deprecated since 1.39; Use getWriteConnection()
     */
    public function getLazyWriteConnectionRef(): DBConnRef
    {
        return $this->getConnectionRef(DB_PRIMARY);
    }

    /**
     * Returns a lazy-connecting database connection ref for reading.
     *
     * @param string[]|null $groups
     * @return DBConnRef
     * @since 1.37
     * @deprecated since 1.39; Use getReadConnection()
     */
    public function getLazyReadConnectionRef(array $groups = null)
    {
        $groups = $groups ?? $this->groups;

        return $this->getConnectionRef(DB_REPLICA, $groups);
    }

}
