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
 * @author This, that and the other
 */

/**
 * @covers NamespaceImportTitleFactory
 *
 * @group Title
 *
 * TODO convert to unit tests
 */
class NamespaceImportTitleFactoryTest extends MediaWikiIntegrationTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->setContentLang('en');
    }

    public function basicProvider()
    {
        return [
            [
                new ForeignTitle(0, '', 'MainNamespaceArticle'),
                0,
                'MainNamespaceArticle'
            ],
            [
                new ForeignTitle(0, '', 'MainNamespaceArticle'),
                2,
                'User:MainNamespaceArticle'
            ],
            [
                new ForeignTitle(1, 'Discussion', 'Nice_talk'),
                0,
                'Nice_talk'
            ],
            [
                new ForeignTitle(0, '', 'Bogus:Nice_talk'),
                0,
                'Bogus:Nice_talk'
            ],
            [
                new ForeignTitle(0, '', 'Bogus:Nice_talk'),
                2,
                'User:Bogus:Nice_talk'
            ],
        ];
    }

    /**
     * @dataProvider basicProvider
     */
    public function testBasic(ForeignTitle $foreignTitle, $ns, $titleText)
    {
        $factory = new NamespaceImportTitleFactory(
            $this->getServiceContainer()->getNamespaceInfo(),
            $this->getServiceContainer()->getTitleFactory(),
            $ns
        );
        $testTitle = $factory->createTitleFromForeignTitle($foreignTitle);
        $title = Title::newFromText($titleText);

        $this->assertTrue($title->equals($testTitle));
    }
}
