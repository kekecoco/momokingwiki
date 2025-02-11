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
 * @since 1.23
 */

use MediaWiki\MainConfigNames;
use MediaWiki\SpecialPage\SpecialPageFactory;
use Wikimedia\ParamValidator\ParamValidator;
use Wikimedia\ParamValidator\TypeDef\IntegerDef;

/**
 * Recent changes feed.
 *
 * @ingroup API
 */
class ApiFeedRecentChanges extends ApiBase
{

    private $params;

    /** @var SpecialPageFactory */
    private $specialPageFactory;

    /**
     * @param ApiMain $mainModule
     * @param string $moduleName
     * @param SpecialPageFactory $specialPageFactory
     */
    public function __construct(
        ApiMain $mainModule,
        string $moduleName,
        SpecialPageFactory $specialPageFactory
    )
    {
        parent::__construct($mainModule, $moduleName);
        $this->specialPageFactory = $specialPageFactory;
    }

    /**
     * This module uses a custom feed wrapper printer.
     *
     * @return ApiFormatFeedWrapper
     */
    public function getCustomPrinter()
    {
        return new ApiFormatFeedWrapper($this->getMain());
    }

    /**
     * Format the rows (generated by SpecialRecentchanges or SpecialRecentchangeslinked)
     * as an RSS/Atom feed.
     */
    public function execute()
    {
        $config = $this->getConfig();

        $this->params = $this->extractRequestParams();

        if (!$config->get(MainConfigNames::Feed)) {
            $this->dieWithError('feed-unavailable');
        }

        $feedClasses = $config->get(MainConfigNames::FeedClasses);
        if (!isset($feedClasses[$this->params['feedformat']])) {
            $this->dieWithError('feed-invalid');
        }

        $this->getMain()->setCacheMode('public');
        if (!$this->getMain()->getParameter('smaxage')) {
            // T65249: This page gets hit a lot, cache at least 15 seconds.
            $this->getMain()->setCacheMaxAge(15);
        }

        $feedFormat = $this->params['feedformat'];
        $specialPageName = $this->params['target'] !== null
            ? 'Recentchangeslinked'
            : 'Recentchanges';

        $formatter = $this->getFeedObject($feedFormat, $specialPageName);

        // Parameters are passed via the request in the context… :(
        $context = new DerivativeContext($this);
        $context->setRequest(new DerivativeRequest(
            $this->getRequest(),
            $this->params,
            $this->getRequest()->wasPosted()
        ));

        // The row-getting functionality should be factored out of ChangesListSpecialPage too…
        $rc = $this->specialPageFactory->getPage($specialPageName);
        if ($rc === null) {
            throw new RuntimeException(__METHOD__ . ' not able to instance special page ' . $specialPageName);
        }
        '@phan-var ChangesListSpecialPage $rc';
        $rc->setContext($context);
        $rows = $rc->getRows();

        $feedItems = $rows ? ChangesFeed::buildItems($rows) : [];

        ApiFormatFeedWrapper::setResult($this->getResult(), $formatter, $feedItems);
    }

    /**
     * Return a ChannelFeed object.
     *
     * @param string $feedFormat Feed's format (either 'rss' or 'atom')
     * @param string $specialPageName Relevant special page name (either 'Recentchanges' or
     *     'Recentchangeslinked')
     * @return ChannelFeed
     */
    private function getFeedObject($feedFormat, $specialPageName)
    {
        if ($specialPageName === 'Recentchangeslinked') {
            $title = Title::newFromText($this->params['target']);
            if (!$title) {
                $this->dieWithError(['apierror-invalidtitle', wfEscapeWikiText($this->params['target'])]);
            }

            $feed = new ChangesFeed($feedFormat);
            $feedObj = $feed->getFeedObject(
                $this->msg('recentchangeslinked-title', $title->getPrefixedText())
                    ->inContentLanguage()->text(),
                $this->msg('recentchangeslinked-feed')->inContentLanguage()->text(),
                SpecialPage::getTitleFor('Recentchangeslinked')->getFullURL()
            );
        } else {
            $feed = new ChangesFeed($feedFormat);
            $feedObj = $feed->getFeedObject(
                $this->msg('recentchanges')->inContentLanguage()->text(),
                $this->msg('recentchanges-feed-description')->inContentLanguage()->text(),
                SpecialPage::getTitleFor('Recentchanges')->getFullURL()
            );
        }

        return $feedObj;
    }

    public function getAllowedParams()
    {
        $config = $this->getConfig();
        $feedFormatNames = array_keys($config->get(MainConfigNames::FeedClasses));

        $ret = [
            'feedformat' => [
                ParamValidator::PARAM_DEFAULT => 'rss',
                ParamValidator::PARAM_TYPE    => $feedFormatNames,
            ],

            'namespace'  => [
                ParamValidator::PARAM_TYPE => 'namespace',
            ],
            'invert'     => false,
            'associated' => false,

            'days'  => [
                ParamValidator::PARAM_DEFAULT => 7,
                IntegerDef::PARAM_MIN         => 1,
                ParamValidator::PARAM_TYPE    => 'integer',
            ],
            'limit' => [
                ParamValidator::PARAM_DEFAULT => 50,
                IntegerDef::PARAM_MIN         => 1,
                IntegerDef::PARAM_MAX         => $config->get(MainConfigNames::FeedLimit),
                ParamValidator::PARAM_TYPE    => 'integer',
            ],
            'from'  => [
                ParamValidator::PARAM_TYPE => 'timestamp',
            ],

            'hideminor'          => false,
            'hidebots'           => false,
            'hideanons'          => false,
            'hideliu'            => false,
            'hidepatrolled'      => false,
            'hidemyself'         => false,
            'hidecategorization' => false,

            'tagfilter' => [
                ParamValidator::PARAM_TYPE => 'string',
            ],

            'target'       => [
                ParamValidator::PARAM_TYPE => 'string',
            ],
            'showlinkedto' => false,
        ];

        return $ret;
    }

    protected function getExamplesMessages()
    {
        return [
            'action=feedrecentchanges'
            => 'apihelp-feedrecentchanges-example-simple',
            'action=feedrecentchanges&days=30'
            => 'apihelp-feedrecentchanges-example-30days',
        ];
    }
}
