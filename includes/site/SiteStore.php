<?php

/**
 * Interface for service objects providing a storage interface for Site objects.
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
 * @since 1.21
 *
 * @file
 * @ingroup Site
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface SiteStore extends SiteLookup
{

    /**
     * Saves the provided site.
     *
     * @param Site $site
     *
     * @return bool Success indicator
     * @since 1.21
     *
     */
    public function saveSite(Site $site);

    /**
     * Saves the provided sites.
     *
     * @param Site[] $sites
     *
     * @return bool Success indicator
     * @since 1.21
     *
     */
    public function saveSites(array $sites);

    /**
     * Deletes all sites from the database. After calling clear(), getSites() will return an empty
     * list and getSite() will return null until saveSite() or saveSites() is called.
     */
    public function clear();
}
