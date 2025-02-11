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
 * @author Trevor Parscal
 * @author Roan Kattouw
 */

namespace MediaWiki\ResourceLoader;

use MediaWiki\MainConfigNames;

/**
 * Module for site style customizations.
 *
 * @ingroup ResourceLoader
 * @internal
 */
class SiteStylesModule extends WikiModule
{
    /** @var string[] What client platforms the module targets (e.g. desktop, mobile) */
    protected $targets = ['desktop', 'mobile'];

    /**
     * Get list of pages used by this module
     *
     * @param Context $context
     * @return array[]
     */
    protected function getPages(Context $context)
    {
        $pages = [];
        if ($this->getConfig()->get(MainConfigNames::UseSiteCss)) {
            $skin = $context->getSkin();
            $pages['MediaWiki:Common.css'] = ['type' => 'style'];
            $pages['MediaWiki:' . ucfirst($skin) . '.css'] = ['type' => 'style'];
            $pages['MediaWiki:Print.css'] = ['type' => 'style', 'media' => 'print'];
            $this->getHookRunner()->onResourceLoaderSiteStylesModulePages($skin, $pages);
        }

        return $pages;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::LOAD_STYLES;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return self::GROUP_SITE;
    }
}

/** @deprecated since 1.39 */
class_alias(SiteStylesModule::class, 'ResourceLoaderSiteStylesModule');
