<?php

use MediaWiki\MainConfigNames;

class TimeAdjustTest extends MediaWikiLangTestCase
{
    /**
     * Test offset usage for a given Language::userAdjust
     * @dataProvider dataUserAdjust
     * @covers       Language::userAdjust
     */
    public function testUserAdjust($date, $localTZoffset, $expected)
    {
        $this->overrideConfigValue(MainConfigNames::LocalTZoffset, $localTZoffset);

        $this->assertEquals(
            $expected,
            strval($this->getServiceContainer()->getContentLanguage()->
            userAdjust($date, '')),
            "User adjust {$date} by {$localTZoffset} minutes should give {$expected}"
        );
    }

    public static function dataUserAdjust()
    {
        return [
            ['20061231235959', 0, '20061231235959'],
            ['20061231235959', 5, '20070101000459'],
            ['20061231235959', 15, '20070101001459'],
            ['20061231235959', 60, '20070101005959'],
            ['20061231235959', 90, '20070101012959'],
            ['20061231235959', 120, '20070101015959'],
            ['20061231235959', 540, '20070101085959'],
            ['20061231235959', -5, '20061231235459'],
            ['20061231235959', -30, '20061231232959'],
            ['20061231235959', -60, '20061231225959'],
        ];
    }
}
