<?php

/**
 * @covers ReadOnlyError
 * @author Addshore
 */
class ReadOnlyErrorTest extends MediaWikiIntegrationTestCase
{

    public function testConstruction()
    {
        $e = new ReadOnlyError();
        $this->assertEquals('readonly', $e->title);
        $this->assertEquals('readonlytext', $e->msg);
        $this->assertEquals($this->getServiceContainer()->getReadOnlyMode()->getReason() ?: [], $e->params);
    }

}
