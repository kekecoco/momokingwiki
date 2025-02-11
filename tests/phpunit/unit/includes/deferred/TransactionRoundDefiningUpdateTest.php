<?php

/**
 * @covers TransactionRoundDefiningUpdate
 */
class TransactionRoundDefiningUpdateTest extends MediaWikiUnitTestCase
{

    public function testDoUpdate()
    {
        $ran = 0;
        $update = new TransactionRoundDefiningUpdate(static function () use (&$ran) {
            $ran++;
        });
        $this->assertSame(0, $ran);
        $update->doUpdate();
        $this->assertSame(1, $ran);
    }
}
