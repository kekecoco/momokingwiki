<?php

use MediaWiki\Revision\RevisionRecord;
use MediaWiki\User\UserIdentity;

/**
 * @covers CategoryMembershipChange
 *
 * @group Database
 *
 * @author Addshore
 */
class CategoryMembershipChangeTest extends MediaWikiLangTestCase
{

    /**
     * @var array|Title[]|User[]
     */
    private static $lastNotifyArgs;

    /**
     * @var int
     */
    private static $notifyCallCounter = 0;

    /**
     * @var RecentChange
     */
    private static $mockRecentChange;

    /**
     * @var RevisionRecord
     */
    private static $pageRev = null;

    /**
     * @var UserIdentity
     */
    private static $revUser = null;

    /**
     * @var string
     */
    private static $pageName = 'CategoryMembershipChangeTestPage';

    public static function newForCategorizationCallback(...$args)
    {
        self::$lastNotifyArgs = $args;
        self::$notifyCallCounter += 1;

        return self::$mockRecentChange;
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$notifyCallCounter = 0;
        self::$mockRecentChange = $this->createMock(RecentChange::class);

        $this->setContentLang('qqx');
    }

    public function addDBDataOnce()
    {
        $info = $this->insertPage(self::$pageName);
        $title = $info['title'];

        $page = WikiPage::factory($title);
        self::$pageRev = $page->getRevisionRecord();
        self::$revUser = self::$pageRev->getUser(RevisionRecord::RAW);
    }

    private function newChange(RevisionRecord $revision = null)
    {
        $title = Title::makeTitle(NS_MAIN, self::$pageName);
        $blcFactory = $this->getServiceContainer()->getBacklinkCacheFactory();
        $change = new CategoryMembershipChange(
            $title, $blcFactory->getBacklinkCache($title), $revision
        );
        $change->overrideNewForCategorizationCallback(
            'CategoryMembershipChangeTest::newForCategorizationCallback'
        );

        return $change;
    }

    public function testChangeAddedNoRev()
    {
        $change = $this->newChange();
        $change->triggerCategoryAddedNotification(Title::makeTitle(NS_CATEGORY, 'CategoryName'));

        $this->assertSame(1, self::$notifyCallCounter);

        $this->assertTrue(strlen(self::$lastNotifyArgs[0]) === 14);
        $this->assertEquals('Category:CategoryName', self::$lastNotifyArgs[1]->getPrefixedText());
        $this->assertEquals('(autochange-username)', self::$lastNotifyArgs[2]->getName());
        $this->assertEquals('(recentchanges-page-added-to-category: ' . self::$pageName . ')',
            self::$lastNotifyArgs[3]);
        $this->assertEquals(self::$pageName, self::$lastNotifyArgs[4]->getPrefixedText());
        $this->assertSame(0, self::$lastNotifyArgs[5]);
        $this->assertSame(0, self::$lastNotifyArgs[6]);
        $this->assertNull(self::$lastNotifyArgs[7]);
        $this->assertSame(1, self::$lastNotifyArgs[8]);
        $this->assertSame('', self::$lastNotifyArgs[9]);
        $this->assertSame(0, self::$lastNotifyArgs[10]);
    }

    public function testChangeRemovedNoRev()
    {
        $change = $this->newChange();
        $change->triggerCategoryRemovedNotification(Title::makeTitle(NS_CATEGORY, 'CategoryName'));

        $this->assertSame(1, self::$notifyCallCounter);

        $this->assertTrue(strlen(self::$lastNotifyArgs[0]) === 14);
        $this->assertEquals('Category:CategoryName', self::$lastNotifyArgs[1]->getPrefixedText());
        $this->assertEquals('(autochange-username)', self::$lastNotifyArgs[2]->getName());
        $this->assertEquals('(recentchanges-page-removed-from-category: ' . self::$pageName . ')',
            self::$lastNotifyArgs[3]);
        $this->assertEquals(self::$pageName, self::$lastNotifyArgs[4]->getPrefixedText());
        $this->assertSame(0, self::$lastNotifyArgs[5]);
        $this->assertSame(0, self::$lastNotifyArgs[6]);
        $this->assertNull(self::$lastNotifyArgs[7]);
        $this->assertSame(1, self::$lastNotifyArgs[8]);
        $this->assertSame('', self::$lastNotifyArgs[9]);
        $this->assertSame(0, self::$lastNotifyArgs[10]);
    }

    public function testChangeAddedWithRev()
    {
        $revision = $this->getServiceContainer()
            ->getRevisionLookup()
            ->getRevisionByTitle(Title::makeTitle(NS_MAIN, self::$pageName));
        $change = $this->newChange($revision);
        $change->triggerCategoryAddedNotification(Title::makeTitle(NS_CATEGORY, 'CategoryName'));

        $this->assertSame(1, self::$notifyCallCounter);

        $this->assertTrue(strlen(self::$lastNotifyArgs[0]) === 14);
        $this->assertEquals('Category:CategoryName', self::$lastNotifyArgs[1]->getPrefixedText());
        $this->assertEquals(self::$revUser->getName(), self::$lastNotifyArgs[2]->getName());
        $this->assertEquals('(recentchanges-page-added-to-category: ' . self::$pageName . ')',
            self::$lastNotifyArgs[3]);
        $this->assertEquals(self::$pageName, self::$lastNotifyArgs[4]->getPrefixedText());
        $this->assertEquals(self::$pageRev->getParentId(), self::$lastNotifyArgs[5]);
        $this->assertEquals($revision->getId(), self::$lastNotifyArgs[6]);
        $this->assertNull(self::$lastNotifyArgs[7]);
        $this->assertSame(0, self::$lastNotifyArgs[8]);
        $this->assertEquals('127.0.0.1', self::$lastNotifyArgs[9]);
        $this->assertSame(0, self::$lastNotifyArgs[10]);
    }

    public function testChangeRemovedWithRev()
    {
        $revision = $this->getServiceContainer()
            ->getRevisionLookup()
            ->getRevisionByTitle(Title::makeTitle(NS_MAIN, self::$pageName));
        $change = $this->newChange($revision);
        $change->triggerCategoryRemovedNotification(Title::makeTitle(NS_CATEGORY, 'CategoryName'));

        $this->assertSame(1, self::$notifyCallCounter);

        $this->assertTrue(strlen(self::$lastNotifyArgs[0]) === 14);
        $this->assertEquals('Category:CategoryName', self::$lastNotifyArgs[1]->getPrefixedText());
        $this->assertEquals(self::$revUser->getName(), self::$lastNotifyArgs[2]->getName());
        $this->assertEquals('(recentchanges-page-removed-from-category: ' . self::$pageName . ')',
            self::$lastNotifyArgs[3]);
        $this->assertEquals(self::$pageName, self::$lastNotifyArgs[4]->getPrefixedText());
        $this->assertEquals(self::$pageRev->getParentId(), self::$lastNotifyArgs[5]);
        $this->assertEquals($revision->getId(), self::$lastNotifyArgs[6]);
        $this->assertNull(self::$lastNotifyArgs[7]);
        $this->assertSame(0, self::$lastNotifyArgs[8]);
        $this->assertEquals('127.0.0.1', self::$lastNotifyArgs[9]);
        $this->assertSame(0, self::$lastNotifyArgs[10]);
    }

}
