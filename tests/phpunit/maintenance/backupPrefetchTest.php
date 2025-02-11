<?php

namespace MediaWiki\Tests\Maintenance;

use BaseDump;
use MediaWiki\Revision\SlotRecord;
use MediaWikiIntegrationTestCase;

/**
 * @group Dump
 * @covers BaseDump
 */
class BaseDumpTest extends MediaWikiIntegrationTestCase
{

    /**
     * @var BaseDump The BaseDump instance used within a test.
     *
     * If set, this BaseDump gets automatically closed in tearDown.
     */
    private $dump = null;

    protected function tearDown(): void
    {
        if ($this->dump !== null) {
            $this->dump->close();
        }

        // T39458, parent teardown need to be done after closing the
        // dump or it might cause some permissions errors.
        parent::tearDown();
    }

    /**
     * asserts that a prefetch yields an expected string
     *
     * @param string|null $expected The exepcted result of the prefetch
     * @param int $page The page number to prefetch the text for
     * @param int $revision The revision number to prefetch the text for
     * @param string $slot The role name of the slot to fetch
     */
    private function assertPrefetchEquals($expected, $page, $revision, $slot = SlotRecord::MAIN)
    {
        $this->assertEquals($expected, $this->dump->prefetch($page, $revision, $slot),
            "Prefetch of page $page revision $revision");
    }

    public function testSequential()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP1Text1", 1, 1);
        $this->assertPrefetchEquals("BackupDumperTestP1Text1aux", 1, 1, 'aux');
        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals("BackupDumperTestP2Text4 some additional Text", 2, 5);
        $this->assertPrefetchEquals("Talk about BackupDumperTestP1 Text1", 4, 8);
    }

    public function testSynchronizeSlotMissToRevision()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP1Text1aux", 1, 1, 'aux');
        $this->assertPrefetchEquals(null, 1, 1, 'xyzzy');
        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 2, 2, 'aux');
        $this->assertPrefetchEquals("BackupDumperTestP2Text4 some additional Text", 2, 5);
    }

    public function testSynchronizeRevisionMissToRevision()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 2, 3);
        $this->assertPrefetchEquals("BackupDumperTestP2Text4 some additional Text", 2, 5);
    }

    public function testSynchronizeRevisionMissToPage()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 2, 40);
        $this->assertPrefetchEquals("Talk about BackupDumperTestP1 Text1", 4, 8);
    }

    public function testSynchronizePageMiss()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 3, 40);
        $this->assertPrefetchEquals("Talk about BackupDumperTestP1 Text1", 4, 8);
    }

    public function testPageMissAtEnd()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 6, 40);
    }

    public function testRevisionMissAtEnd()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals(null, 4, 40);
    }

    public function testSynchronizePageMissAtStart()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals(null, 0, 2);
        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
    }

    public function testSynchronizeRevisionMissAtStart()
    {
        $fname = $this->setUpPrefetch();
        $this->dump = new BaseDump($fname);

        $this->assertPrefetchEquals(null, 1, -2);
        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
    }

    public function testSequentialAcrossFiles()
    {
        $fname1 = $this->setUpPrefetch([1]);
        $fname2 = $this->setUpPrefetch([2, 4]);
        $this->dump = new BaseDump($fname1 . ";" . $fname2);

        $this->assertPrefetchEquals("BackupDumperTestP1Text1", 1, 1);
        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
        $this->assertPrefetchEquals("BackupDumperTestP2Text4 some additional Text", 2, 5);
        $this->assertPrefetchEquals("Talk about BackupDumperTestP1 Text1", 4, 8);
    }

    public function testSynchronizeSkipAcrossFile()
    {
        $fname1 = $this->setUpPrefetch([1]);
        $fname2 = $this->setUpPrefetch([2]);
        $fname3 = $this->setUpPrefetch([4]);
        $this->dump = new BaseDump($fname1 . ";" . $fname2 . ";" . $fname3);

        $this->assertPrefetchEquals("BackupDumperTestP1Text1", 1, 1);
        $this->assertPrefetchEquals("Talk about BackupDumperTestP1 Text1", 4, 8);
    }

    public function testSynchronizeMissInWholeFirstFile()
    {
        $fname1 = $this->setUpPrefetch([1]);
        $fname2 = $this->setUpPrefetch([2]);
        $this->dump = new BaseDump($fname1 . ";" . $fname2);

        $this->assertPrefetchEquals("BackupDumperTestP2Text1", 2, 2);
    }

    /**
     * Constructs a temporary file that can be used for prefetching
     *
     * The temporary file is removed by DumpBackup upon tearDown.
     *
     * @param array $requested_pages The indices of the page parts that should
     *    go into the prefetch file. 1,2,4 are available.
     * @return string The file name of the created temporary file
     */
    private function setUpPrefetch($requested_pages = [1, 2, 4])
    {
        // The file name, where we store the prepared prefetch file
        $fname = $this->getNewTempFile();

        // The header of every prefetch file
        $header = '<mediawiki>
  <siteinfo>
    <sitename>wikisvn</sitename>
    <base>http://localhost/wiki-svn/index.php/Main_Page</base>
    <generator>MediaWiki 1.21alpha</generator>
    <case>first-letter</case>
    <namespaces>
      <namespace key="-2" case="first-letter">Media</namespace>
      <namespace key="-1" case="first-letter">Special</namespace>
      <namespace key="0" case="first-letter" />
      <namespace key="1" case="first-letter">Talk</namespace>
      <namespace key="2" case="first-letter">User</namespace>
      <namespace key="3" case="first-letter">User talk</namespace>
      <namespace key="4" case="first-letter">Wikisvn</namespace>
      <namespace key="5" case="first-letter">Wikisvn talk</namespace>
      <namespace key="6" case="first-letter">File</namespace>
      <namespace key="7" case="first-letter">File talk</namespace>
      <namespace key="8" case="first-letter">MediaWiki</namespace>
      <namespace key="9" case="first-letter">MediaWiki talk</namespace>
      <namespace key="10" case="first-letter">Template</namespace>
      <namespace key="11" case="first-letter">Template talk</namespace>
      <namespace key="12" case="first-letter">Help</namespace>
      <namespace key="13" case="first-letter">Help talk</namespace>
      <namespace key="14" case="first-letter">Category</namespace>
      <namespace key="15" case="first-letter">Category talk</namespace>
    </namespaces>
  </siteinfo>
';

        // An array holding the pages that are available for prefetch
        $available_pages = [];

        // Simple plain page
        $available_pages[1] = '  <page>
    <title>BackupDumperTestP1</title>
    <ns>0</ns>
    <id>1</id>
    <revision>
      <id>1</id>
      <timestamp>2012-04-01T16:46:05Z</timestamp>
      <contributor>
        <ip>127.0.0.1</ip>
      </contributor>
      <comment>BackupDumperTestP1Summary1</comment>
      <text xml:space="preserve">BackupDumperTestP1Text1</text>
      <model name="wikitext">1</model>
      <format mime="text/x-wiki">1</format>
		<content>
			<role>aux</role>
			<origin>2</origin>
			<model>wikitext</model>
			<format>text/x-wiki</format>
			<text sha1="deadbeef" xml:space="preserve">BackupDumperTestP1Text1aux</text>
		</content>
      <sha1>0bolhl6ol7i6x0e7yq91gxgaan39j87</sha1>
    </revision>
  </page>
';
        // Page with more than one revisions. Hole in rev ids.
        $available_pages[2] = '  <page>
    <title>BackupDumperTestP2</title>
    <ns>0</ns>
    <id>2</id>
    <revision>
      <id>2</id>
      <timestamp>2012-04-01T16:46:05Z</timestamp>
      <contributor>
        <ip>127.0.0.1</ip>
      </contributor>
      <comment>BackupDumperTestP2Summary1</comment>
      <sha1>jprywrymfhysqllua29tj3sc7z39dl2</sha1>
      <text xml:space="preserve">BackupDumperTestP2Text1</text>
      <model name="wikitext">1</model>
      <format mime="text/x-wiki">1</format>
    </revision>
    <revision>
      <id>5</id>
      <parentid>2</parentid>
      <timestamp>2012-04-01T16:46:05Z</timestamp>
      <contributor>
        <ip>127.0.0.1</ip>
      </contributor>
      <comment>BackupDumperTestP2Summary4 extra</comment>
      <sha1>6o1ciaxa6pybnqprmungwofc4lv00wv</sha1>
      <text xml:space="preserve">BackupDumperTestP2Text4 some additional Text</text>
      <model name="wikitext">1</model>
      <format mime="text/x-wiki">1</format>
    </revision>
  </page>
';
        // Page with id higher than previous id + 1
        $available_pages[4] = '  <page>
    <title>Talk:BackupDumperTestP1</title>
    <ns>1</ns>
    <id>4</id>
    <revision>
      <id>8</id>
      <timestamp>2012-04-01T16:46:05Z</timestamp>
      <contributor>
        <ip>127.0.0.1</ip>
      </contributor>
      <comment>Talk BackupDumperTestP1 Summary1</comment>
      <sha1>nktofwzd0tl192k3zfepmlzxoax1lpe</sha1>
      <model name="wikitext">1</model>
      <format mime="text/x-wiki">1</format>
      <text xml:space="preserve">Talk about BackupDumperTestP1 Text1</text>
    </revision>
  </page>
';

        // The common ending for all files
        $tail = '</mediawiki>
';

        // Putting together the content of the prefetch files
        $content = $header;
        foreach ($requested_pages as $i) {
            $this->assertArrayHasKey($i, $available_pages,
                "Check for availability of requested page " . $i);
            $content .= $available_pages[$i];
        }
        $content .= $tail;

        $this->assertEquals(strlen($content), file_put_contents(
            $fname, $content), "Length of prepared prefetch");

        return $fname;
    }
}
