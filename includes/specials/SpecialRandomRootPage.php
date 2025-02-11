<?php

use Wikimedia\Rdbms\ILoadBalancer;

/**
 * Implements Special:Randomrootpage
 *
 * Copyright © 2008 Hojjat (aka Huji)
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
 * @ingroup SpecialPage
 */
class SpecialRandomRootPage extends SpecialRandomPage
{

    /**
     * @param ILoadBalancer $loadBalancer
     * @param NamespaceInfo $nsInfo
     */
    public function __construct(
        ILoadBalancer $loadBalancer,
        NamespaceInfo $nsInfo
    )
    {
        parent::__construct($loadBalancer, $nsInfo);
        $this->mName = 'Randomrootpage';
        $dbr = $loadBalancer->getConnectionRef(ILoadBalancer::DB_REPLICA);
        $this->extra[] = 'page_title NOT ' . $dbr->buildLike($dbr->anyString(), '/', $dbr->anyString());
    }

    // Don't select redirects
    public function isRedirect()
    {
        return false;
    }
}
