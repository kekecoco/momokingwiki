<?php
/**
 * Authentication provider interface
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
 * @ingroup Auth
 */

namespace MediaWiki\Auth;

use Config;
use MediaWiki\HookContainer\HookContainer;

/**
 * An AuthenticationProvider is used by AuthManager when authenticating users.
 *
 * This interface should not be implemented directly; use one of its children.
 *
 * Authentication providers can be registered via $wgAuthManagerAutoConfig.
 *
 * @ingroup Auth
 * @since 1.27
 */
interface AuthenticationProvider
{

    /**
     * Set AuthManager
     * @param AuthManager $manager
     * @deprecated since 1.37. For extension-defined authentication providers
     * that were using this method to trigger other work, please override
     * AbstractAuthenticationProvider::postInitSetup instead. If your extension
     * was using this to explicitly change the AuthManager (or Config, or
     * HookContainer) of an existing AuthenticationProvider object, please
     * file a report on phabricator - there is no non-deprecated way to do this
     * anymore.
     */
    public function setManager(AuthManager $manager);

    /**
     * Set configuration
     * @param Config $config
     * @deprecated since 1.37. For extension-defined authentication providers
     * that were using this method to trigger other work, please override
     * AbstractAuthenticationProvider::postInitSetup instead. If your extension
     * was using this to explicitly change the AuthManager (or Config, or
     * HookContainer) of an existing AuthenticationProvider object, please
     * file a report on phabricator - there is no non-deprecated way to do this
     * anymore.
     */
    public function setConfig(Config $config);

    /**
     * @param HookContainer $hookContainer
     * @deprecated since 1.37. For extension-defined authentication providers
     * that were using this method to trigger other work, please override
     * AbstractAuthenticationProvider::postInitSetup instead. If your extension
     * was using this to explicitly change the AuthManager (or Config, or
     * HookContainer) of an existing AuthenticationProvider object, please
     * file a report on phabricator - there is no non-deprecated way to do this
     * anymore.
     */
    public function setHookContainer(HookContainer $hookContainer);

    /**
     * Return a unique identifier for this instance
     *
     * This must be the same across requests. If multiple instances return the
     * same ID, exceptions will be thrown from AuthManager.
     *
     * @return string
     */
    public function getUniqueId();

    /**
     * Return the applicable list of AuthenticationRequests
     *
     * Possible values for $action depend on whether the implementing class is
     * also a PreAuthenticationProvider, PrimaryAuthenticationProvider, or
     * SecondaryAuthenticationProvider.
     *  - ACTION_LOGIN: Valid for passing to beginAuthentication. Called on all
     *    providers.
     *  - ACTION_CREATE: Valid for passing to beginAccountCreation. Called on
     *    all providers.
     *  - ACTION_LINK: Valid for passing to beginAccountLink. Called on linking
     *    primary providers only.
     *  - ACTION_CHANGE: Valid for passing to AuthManager::changeAuthenticationData
     *    to change credentials. Called on primary and secondary providers.
     *  - ACTION_REMOVE: Valid for passing to AuthManager::changeAuthenticationData
     *    to remove credentials. Must work without additional user input (i.e.
     *    without calling loadFromSubmission). Called on primary and secondary
     *    providers.
     *
     * @param string $action
     * @param array $options Options are:
     *  - username: User name related to the action, or null/unset if anon.
     *    - ACTION_LOGIN: The currently logged-in user, if any.
     *    - ACTION_CREATE: The account creator, if non-anonymous.
     *    - ACTION_LINK: The local user being linked to.
     *    - ACTION_CHANGE: The user having data changed.
     *    - ACTION_REMOVE: The user having data removed.
     *    If you leave the username property of the returned requests empty, this
     *    will automatically be copied there (except for ACTION_CREATE where it
     *    wouldn't really make sense).
     * @return AuthenticationRequest[]
     * @see AuthManager::getAuthenticationRequests()
     */
    public function getAuthenticationRequests($action, array $options);

}
