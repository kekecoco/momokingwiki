<?php

/**
 * Holds sites for testing purposes.
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
 * @since 1.21
 *
 * @ingroup Site
 * @ingroup Test
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TestSites
{

    /**
     * @return array
     * @since 1.21
     *
     */
    public static function getSites()
    {
        $sites = [];

        $site = new Site();
        $site->setGlobalId('foobar');
        $sites[] = $site;

        $site = new MediaWikiSite();
        $site->setGlobalId('enwiktionary');
        $site->setGroup('wiktionary');
        $site->setLanguageCode('en');
        $site->addNavigationId('enwiktionary');
        $site->setPath(MediaWikiSite::PATH_PAGE, "https://en.wiktionary.org/wiki/$1");
        $site->setPath(MediaWikiSite::PATH_FILE, "https://en.wiktionary.org/w/$1");
        $sites[] = $site;

        $site = new MediaWikiSite();
        $site->setGlobalId('dewiktionary');
        $site->setGroup('wiktionary');
        $site->setLanguageCode('de');
        $site->addInterwikiId('dewiktionary');
        $site->addInterwikiId('wiktionaryde');
        $site->setPath(MediaWikiSite::PATH_PAGE, "https://de.wiktionary.org/wiki/$1");
        $site->setPath(MediaWikiSite::PATH_FILE, "https://de.wiktionary.org/w/$1");
        $sites[] = $site;

        $site = new Site();
        $site->setGlobalId('spam');
        $site->setGroup('spam');
        $site->setLanguageCode('en');
        $site->addNavigationId('spam');
        $site->addNavigationId('spamz');
        $site->addInterwikiId('spamzz');
        $site->setLinkPath("http://spamzz.test/testing/");
        $sites[] = $site;

        /**
         * Add at least one right-to-left language (current RTL languages in MediaWiki core are:
         * aeb, ar, arc, arz, azb, bcc, bqi, ckb, dv, en_rtl, fa, glk, he, khw, kk_arab, kk_cn,
         * ks_arab, ku_arab, lrc, mzn, pnb, ps, sd, ug_arab, ur, yi).
         */
        $languageCodes = [
            'de',
            'en',
            'fa', // right-to-left
            'nl',
            'nn',
            'no',
            'sr',
            'sv',
        ];
        foreach ($languageCodes as $langCode) {
            $site = new MediaWikiSite();
            $site->setGlobalId($langCode . 'wiki');
            $site->setGroup('wikipedia');
            $site->setLanguageCode($langCode);
            $site->addInterwikiId($langCode);
            $site->addNavigationId($langCode);
            $site->setPath(MediaWikiSite::PATH_PAGE, "https://$langCode.wikipedia.org/wiki/$1");
            $site->setPath(MediaWikiSite::PATH_FILE, "https://$langCode.wikipedia.org/w/$1");
            $sites[] = $site;
        }

        return $sites;
    }

    /**
     * Inserts sites into the database for the unit tests that need them.
     *
     * @since 0.1
     */
    public static function insertIntoDb()
    {
        $sitesTable = \MediaWiki\MediaWikiServices::getInstance()->getSiteStore();
        $sitesTable->clear();
        $sitesTable->saveSites(self::getSites());
    }
}
