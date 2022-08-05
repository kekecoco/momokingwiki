<?php

use MediaWiki\Tests\TestMode as ParserTestMode;
use Wikimedia\Parsoid\ParserTests\Test as ParserTest;

/**
 * This is the TestCase subclass for running a single parser test via the
 * ParserTestRunner integration test system.
 *
 * Note: the following groups are not used by PHPUnit.
 * The list in ParserTestFileSuite::__construct() is used instead.
 *
 * @group large
 * @group Database
 * @group Parser
 * @group ParserTests
 *
 * @covers Parser
 * @covers BlockLevelPass
 * @covers CoreParserFunctions
 * @covers CoreTagHooks
 * @covers Sanitizer
 * @covers Preprocessor
 * @covers Preprocessor_Hash
 * @covers DateFormatter
 * @covers LinkHolderArray
 * @covers StripState
 * @covers ParserOptions
 * @covers ParserOutput
 */
class ParserIntegrationTest extends PHPUnit\Framework\TestCase
{

    use MediaWikiCoversValidator;
    use MediaWikiTestCaseTrait;

    /** @var ParserTest */
    private $ptTest;

    /** @var ParserTestMode */
    private $ptMode;

    /** @var ParserTestRunner */
    private $ptRunner;

    /** @var string|null */
    private $skipMessage;

    public function __construct($runner, $fileName, ParserTest $test, ParserTestMode $mode, $skipMessage = null)
    {
        parent::__construct('testParse',
            ["$mode"],
            basename($fileName) . ': ' . $test->testName);
        $this->ptTest = $test;
        $this->ptTestMode = $mode;
        $this->ptRunner = $runner;
        $this->skipMessage = $skipMessage;
    }

    public function testParse()
    {
        if ($this->skipMessage !== null) {
            $this->markTestSkipped($this->skipMessage);
        }
        $this->ptRunner->getRecorder()->setTestCase($this);
        $result = $this->ptRunner->runTest($this->ptTest, $this->ptTestMode);
        if ($result === false) {
            // Test intentionally skipped.
            $result = new ParserTestResult($this->ptTest, $this->ptTestMode, "SKIP", "SKIP");
        }
        $this->assertEquals($result->expected, $result->actual);
    }
}
