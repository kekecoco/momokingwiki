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
 * @author Niklas Laxström
 */

use MediaWiki\Linker\LinkTarget;
use MediaWiki\MediaWikiServices;
use MediaWiki\User\UserIdentity;
use MediaWiki\User\UserOptionsLookup;
use Wikimedia\Rdbms\ILoadBalancer;

/**
 * Caches user genders when needed to use correct namespace aliases.
 *
 * @since 1.18
 * @ingroup Cache
 */
class GenderCache
{
    protected $cache = [];
    protected $default;
    protected $misses = 0;
    protected $missLimit = 1000;

    /** @var NamespaceInfo */
    private $nsInfo;

    /** @var ILoadBalancer|null */
    private $loadBalancer;

    /** @var UserOptionsLookup */
    private $userOptionsLookup;

    public function __construct(
        NamespaceInfo $nsInfo = null,
        ILoadBalancer $loadBalancer = null,
        UserOptionsLookup $userOptionsLookup = null
    )
    {
        $this->nsInfo = $nsInfo ?? MediaWikiServices::getInstance()->getNamespaceInfo();
        $this->loadBalancer = $loadBalancer;
        $this->userOptionsLookup = $userOptionsLookup ?? MediaWikiServices::getInstance()->getUserOptionsLookup();
    }

    /**
     * Returns the default gender option in this wiki.
     * @return string
     */
    protected function getDefault()
    {
        if ($this->default === null) {
            $this->default = $this->userOptionsLookup->getDefaultOption('gender');
        }

        return $this->default;
    }

    /**
     * Returns the gender for given username.
     * @param string|UserIdentity $username
     * @param string $caller The calling method
     * @return string
     */
    public function getGenderOf($username, $caller = '')
    {
        if ($username instanceof UserIdentity) {
            $username = $username->getName();
        }

        $username = self::normalizeUsername($username);
        if (!isset($this->cache[$username])) {
            if ($this->misses >= $this->missLimit &&
                RequestContext::getMain()->getUser()->getName() !== $username
            ) {
                if ($this->misses === $this->missLimit) {
                    $this->misses++;
                    wfDebug(__METHOD__ . ": too many misses, returning default onwards");
                }

                return $this->getDefault();
            } else {
                $this->misses++;
                $this->doQuery($username, $caller);
            }
        }

        /* Undefined if there is a valid username which for some reason doesn't
         * exist in the database.
         */

        return $this->cache[$username] ?? $this->getDefault();
    }

    /**
     * Wrapper for doQuery that processes raw LinkBatch data.
     *
     * @param array $data
     * @param string $caller
     */
    public function doLinkBatch($data, $caller = '')
    {
        $users = [];
        foreach ($data as $ns => $pagenames) {
            if (!$this->nsInfo->hasGenderDistinction($ns)) {
                continue;
            }
            foreach (array_keys($pagenames) as $username) {
                $users[$username] = true;
            }
        }

        $this->doQuery(array_keys($users), $caller);
    }

    /**
     * Wrapper for doQuery that processes a title array.
     *
     * @param LinkTarget[] $titles
     * @param string $caller The calling method
     * @since 1.20
     */
    public function doTitlesArray($titles, $caller = '')
    {
        $users = [];
        foreach ($titles as $titleObj) {
            if (!$this->nsInfo->hasGenderDistinction($titleObj->getNamespace())) {
                continue;
            }
            $users[] = $titleObj->getText();
        }

        $this->doQuery($users, $caller);
    }

    /**
     * Preloads genders for given list of users.
     * @param string[]|string $users Usernames
     * @param string $caller The calling method
     */
    public function doQuery($users, $caller = '')
    {
        $default = $this->getDefault();

        $usersToCheck = [];
        foreach ((array)$users as $value) {
            $name = self::normalizeUsername($value);
            // Skip users whose gender setting we already know
            if (!isset($this->cache[$name])) {
                // For existing users, this value will be overwritten by the correct value
                $this->cache[$name] = $default;
                // We no longer verify that only valid names are checked for, T267054
                $usersToCheck[] = $name;
            }
        }

        if (count($usersToCheck) === 0) {
            return;
        }

        // Only query database, when load balancer is provided by service wiring
        // This maybe not happen when running as part of the installer
        if ($this->loadBalancer === null) {
            return;
        }

        $dbr = $this->loadBalancer->getConnectionRef(DB_REPLICA);
        $table = ['user', 'user_properties'];
        $fields = ['user_name', 'up_value'];
        $conds = ['user_name' => $usersToCheck];
        $joins = ['user_properties' =>
                      ['LEFT JOIN', ['user_id = up_user', 'up_property' => 'gender']]];

        $comment = __METHOD__;
        if (strval($caller) !== '') {
            $comment .= "/$caller";
        }
        $res = $dbr->select($table, $fields, $conds, $comment, [], $joins);

        foreach ($res as $row) {
            $this->cache[$row->user_name] = $row->up_value ?: $default;
        }
    }

    private static function normalizeUsername($username)
    {
        // Strip off subpages
        $indexSlash = strpos($username, '/');
        if ($indexSlash !== false) {
            $username = substr($username, 0, $indexSlash);
        }

        // normalize underscore/spaces
        return strtr($username, '_', ' ');
    }
}
