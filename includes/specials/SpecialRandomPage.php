<?php
/**
 * Implements Special:Randompage
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
 * @author Rob Church <robchur@gmail.com>, Ilmari Karonen
 */

use MediaWiki\MediaWikiServices;
use Wikimedia\Rdbms\ILoadBalancer;

/**
 * Special page to direct the user to a random page
 *
 * @ingroup SpecialPage
 */
class SpecialRandomPage extends SpecialPage
{
    private $namespaces; // namespaces to select pages from
    protected $isRedir = false; // should the result be a redirect?
    protected $extra = []; // Extra SQL statements

    /** @var ILoadBalancer */
    private $loadBalancer;

    /**
     * @param ILoadBalancer|string|null $loadBalancer
     * @param NamespaceInfo|null $nsInfo
     */
    public function __construct(
        $loadBalancer = null,
        NamespaceInfo $nsInfo = null
    )
    {
        parent::__construct(is_string($loadBalancer) ? $loadBalancer : 'Randompage');
        // This class is extended and therefor fallback to global state - T265308
        $services = MediaWikiServices::getInstance();
        $this->loadBalancer = $loadBalancer instanceof ILoadBalancer
            ? $loadBalancer
            : $services->getDBLoadBalancer();
        $nsInfo = $nsInfo ?? $services->getNamespaceInfo();
        $this->namespaces = $nsInfo->getContentNamespaces();
    }

    public function getNamespaces()
    {
        return $this->namespaces;
    }

    public function setNamespace($ns)
    {
        if (!$ns || $ns < NS_MAIN) {
            $ns = NS_MAIN;
        }
        $this->namespaces = [$ns];
    }

    // select redirects instead of normal pages?
    public function isRedirect()
    {
        return $this->isRedir;
    }

    public function execute($par)
    {
        if (is_string($par)) {
            // Testing for stringiness since we want to catch
            // the empty string to mean main namespace only.
            $this->setNamespace($this->getContentLanguage()->getNsIndex($par));
        }

        $title = $this->getRandomTitle();

        if ($title === null) {
            $this->setHeaders();
            // Message: randompage-nopages, randomredirect-nopages
            $this->getOutput()->addWikiMsg(strtolower($this->getName()) . '-nopages',
                $this->getNsList(), count($this->namespaces));

            return;
        }

        $redirectParam = $this->isRedirect() ? ['redirect' => 'no'] : [];
        $query = array_merge($this->getRequest()->getValues(), $redirectParam);
        unset($query['title']);
        $this->getOutput()->redirect($title->getFullURL($query));
    }

    /**
     * Get a comma-delimited list of namespaces we don't have
     * any pages in
     * @return string
     */
    private function getNsList()
    {
        $contLang = $this->getContentLanguage();
        $nsNames = [];
        foreach ($this->namespaces as $n) {
            if ($n === NS_MAIN) {
                $nsNames[] = $this->msg('blanknamespace')->plain();
            } else {
                $nsNames[] = $contLang->getNsText($n);
            }
        }

        return $contLang->commaList($nsNames);
    }

    /**
     * Choose a random title.
     * @return Title|null Title object (or null if nothing to choose from)
     */
    public function getRandomTitle()
    {
        $randstr = wfRandom();
        $title = null;

        if (!$this->getHookRunner()->onSpecialRandomGetRandomTitle(
            $randstr, $this->isRedir, $this->namespaces,
            // @phan-suppress-next-line PhanTypeMismatchArgument Type mismatch on pass-by-ref args
            $this->extra, $title)
        ) {
            return $title;
        }

        $row = $this->selectRandomPageFromDB($randstr, __METHOD__);

        /* If we picked a value that was higher than any in
         * the DB, wrap around and select the page with the
         * lowest value instead!  One might think this would
         * skew the distribution, but in fact it won't cause
         * any more bias than what the page_random scheme
         * causes anyway.  Trust me, I'm a mathematician. :)
         */
        if (!$row) {
            $row = $this->selectRandomPageFromDB("0", __METHOD__);
        }

        if ($row) {
            return Title::makeTitleSafe($row->page_namespace, $row->page_title);
        }

        return null;
    }

    protected function getQueryInfo($randstr)
    {
        $redirect = $this->isRedirect() ? 1 : 0;
        $tables = ['page'];
        $conds = array_merge([
            'page_namespace'   => $this->namespaces,
            'page_is_redirect' => $redirect,
            'page_random >= ' . $randstr
        ], $this->extra);
        $joinConds = [];

        // Allow extensions to modify the query
        $this->getHookRunner()->onRandomPageQuery($tables, $conds, $joinConds);

        return [
            'tables'     => $tables,
            'fields'     => ['page_title', 'page_namespace'],
            'conds'      => $conds,
            'options'    => [
                'ORDER BY' => 'page_random',
                'LIMIT'    => 1,
            ],
            'join_conds' => $joinConds
        ];
    }

    private function selectRandomPageFromDB($randstr, $fname = __METHOD__)
    {
        $dbr = $this->loadBalancer->getConnectionRef(ILoadBalancer::DB_REPLICA);

        $query = $this->getQueryInfo($randstr);
        $res = $dbr->select(
            $query['tables'],
            $query['fields'],
            $query['conds'],
            $fname,
            $query['options'],
            $query['join_conds']
        );

        return $res->fetchObject();
    }

    protected function getGroupName()
    {
        return 'redirects';
    }
}

/**
 * Retain the old class name for backwards compatibility.
 * @deprecated since 1.37
 */
class_alias(SpecialRandomPage::class, 'RandomPage');
