<?php

use Wikimedia\TestingAccessWrapper;

/**
 * Just to test one deprecated method and one line of ServiceWiring code.
 */
class TempFSFileIntegrationTest extends MediaWikiIntegrationTestCase
{
    use TempFSFileTestTrait;

    /**
     * @coversNothing
     */
    public function testServiceWiring()
    {
        $this->setMwGlobals('wgTmpDirectory', '/hopefully invalid');
        $factory = $this->getServiceContainer()->getTempFSFileFactory();
        $this->assertSame('/hopefully invalid',
            (TestingAccessWrapper::newFromObject($factory))->tmpDirectory);
    }

    // For TempFSFileTestTrait
    private function newFile()
    {
        return TempFSFile::factory('tmp');
    }
}
