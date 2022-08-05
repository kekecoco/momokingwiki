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
 */

use MediaWiki\MediaWikiServices;

/**
 * @deprecated since 1.38, hard deprecated since 1.39
 * Use GrantsInfo and GrantsLocalization instead
 *
 * A collection of public static functions to deal with grants.
 */
class MWGrants
{

    /**
     * List all known grants.
     * @return array
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::getValidGrants() instead
     */
    public static function getValidGrants()
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->getValidGrants();
    }

    /**
     * Map all grants to corresponding user rights.
     * @return array grant => array of rights
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::getRightsByGrant() instead
     */
    public static function getRightsByGrant()
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->getRightsByGrant();
    }

    /**
     * Fetch the description of the grant
     * @param string $grant
     * @param Language|string|null $lang
     * @return string Grant description
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsLocalization::getGrantDescription() instead
     */
    public static function grantName($grant, $lang = null)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsLocalization()->getGrantDescription($grant, $lang);
    }

    /**
     * Fetch the descriptions for the grants.
     * @param string[] $grants
     * @param Language|string|null $lang
     * @return string[] Corresponding grant descriptions
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsLocalization::getGrantDescriptions() instead
     */
    public static function grantNames(array $grants, $lang = null)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsLocalization()->getGrantDescriptions($grants, $lang);
    }

    /**
     * Fetch the rights allowed by a set of grants.
     * @param string[]|string $grants
     * @return string[]
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::getGrantRights() instead
     */
    public static function getGrantRights($grants)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->getGrantRights($grants);
    }

    /**
     * Test that all grants in the list are known.
     * @param string[] $grants
     * @return bool
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::grantsAreValid() instead
     */
    public static function grantsAreValid(array $grants)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->grantsAreValid($grants);
    }

    /**
     * Divide the grants into groups.
     * @param string[]|null $grantsFilter
     * @return array Map of (group => (grant list))
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::getGrantGroups() instead
     */
    public static function getGrantGroups($grantsFilter = null)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->getGrantGroups($grantsFilter);
    }

    /**
     * Get the list of grants that are hidden and should always be granted
     * @return string[]
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsInfo::getHiddenGrants() instead
     */
    public static function getHiddenGrants()
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsInfo()->getHiddenGrants();
    }

    /**
     * Generate a link to Special:ListGrants for a particular grant name.
     *
     * This should be used to link end users to a full description of what
     * rights they are giving when they authorize a grant.
     *
     * @param string $grant the grant name
     * @param Language|string|null $lang
     * @return string (proto-relative) HTML link
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsLocalization::getGrantsLink() instead
     *
     */
    public static function getGrantsLink($grant, $lang = null)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsLocalization()->getGrantsLink($grant, $lang);
    }

    /**
     * Generate wikitext to display a list of grants
     * @param string[]|null $grantsFilter If non-null, only display these grants.
     * @param Language|string|null $lang
     * @return string Wikitext
     * @deprecated since 1.38, hard deprecated since 1.39
     * Use GrantsLocalization::getGrantsWikiText() instead
     *
     */
    public static function getGrantsWikiText($grantsFilter, $lang = null)
    {
        wfDeprecated(__METHOD__, '1.38');

        return MediaWikiServices::getInstance()->getGrantsLocalization()->getGrantsWikiText($grantsFilter, $lang);
    }

}
