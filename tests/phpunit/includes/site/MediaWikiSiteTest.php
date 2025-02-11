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
 * @since 1.21
 *
 * @ingroup Site
 * @ingroup Test
 *
 * @group Site
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiSiteTest extends SiteTest
{

    /**
     * @covers MediaWikiSite::normalizePageName
     */
    public function testNormalizePageTitle()
    {
        $this->setMwGlobals([
            'wgCapitalLinks' => true,
        ]);

        $site = new MediaWikiSite();
        $site->setGlobalId('enwiki');

        // NOTE: this does not actually call out to the enwiki site to perform the normalization,
        //      but uses a local Title object to do so. This is hardcoded on SiteLink::normalizePageTitle
        //      for the case that MW_PHPUNIT_TEST is set.
        $this->assertEquals('Foo', $site->normalizePageName(' foo '));
    }

    public function fileUrlProvider()
    {
        return [
            // url, filepath, path arg, expected
            ['https://en.wikipedia.org', '/w/$1', 'api.php', 'https://en.wikipedia.org/w/api.php'],
            ['https://en.wikipedia.org', '/w/', 'api.php', 'https://en.wikipedia.org/w/'],
            [
                'https://en.wikipedia.org',
                '/foo/page.php?name=$1',
                'api.php',
                'https://en.wikipedia.org/foo/page.php?name=api.php'
            ],
            [
                'https://en.wikipedia.org',
                '/w/$1',
                '',
                'https://en.wikipedia.org/w/'
            ],
            [
                'https://en.wikipedia.org',
                '/w/$1',
                'foo/bar/api.php',
                'https://en.wikipedia.org/w/foo/bar/api.php'
            ],
        ];
    }

    /**
     * @dataProvider fileUrlProvider
     * @covers       MediaWikiSite::getFileUrl
     */
    public function testGetFileUrl($url, $filePath, $pathArgument, $expected)
    {
        $site = new MediaWikiSite();
        $site->setFilePath($url . $filePath);

        $this->assertEquals($expected, $site->getFileUrl($pathArgument));
    }

    public static function provideGetPageUrl()
    {
        return [
            // path, page, expected substring
            ['http://acme.test/wiki/$1', 'Berlin', '/wiki/Berlin'],
            ['http://acme.test/wiki/', 'Berlin', '/wiki/'],
            ['http://acme.test/w/index.php?title=$1', 'Berlin', '/w/index.php?title=Berlin'],
            ['http://acme.test/wiki/$1', '', '/wiki/'],
            ['http://acme.test/wiki/$1', 'Berlin/sub page', '/wiki/Berlin/sub_page'],
            ['http://acme.test/wiki/$1', 'Cork (city)   ', '/Cork_(city)'],
            ['http://acme.test/wiki/$1', 'M&M', '/wiki/M%26M'],
        ];
    }

    /**
     * @dataProvider provideGetPageUrl
     * @covers       MediaWikiSite::getPageUrl
     */
    public function testGetPageUrl($path, $page, $expected)
    {
        $site = new MediaWikiSite();
        $site->setLinkPath($path);

        $this->assertStringContainsString($path, $site->getPageUrl());
        $this->assertStringContainsString($expected, $site->getPageUrl($page));
    }
}
