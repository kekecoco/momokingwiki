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
 */

/**
 * @covers Xhprof
 */
class XhprofTest extends PHPUnit\Framework\TestCase
{

    use MediaWikiCoversValidator;

    /**
     * @dataProvider provideCallAny
     */
    public function testCallAny(array $functions, array $args, $expectedResult)
    {
        $xhprof = new ReflectionClass(Xhprof::class);
        $callAny = $xhprof->getMethod('callAny');
        $callAny->setAccessible(true);

        $this->assertEquals($expectedResult,
            $callAny->invoke(null, $functions, $args));
    }

    /**
     * Data provider for callAny(), which calls the first function found.
     */
    public function provideCallAny()
    {
        return [
            [
                ['wfTestCallAny_func1', 'wfTestCallAny_func2', 'wfTestCallAny_func3'],
                [3, 4],
                12
            ],
            [
                ['wfTestCallAny_nosuchfunc1', 'wfTestCallAny_func2', 'wfTestCallAny_func3'],
                [3, 4],
                7
            ],
            [
                ['wfTestCallAny_nosuchfunc1', 'wfTestCallAny_nosuchfunc2', 'wfTestCallAny_func3'],
                [3, 4],
                -1
            ]

        ];
    }

    /**
     * callAny() throws an exception when all functions are unavailable.
     *
     * @covers Xhprof::callAny
     */
    public function testCallAnyNoneAvailable()
    {
        $xhprof = new ReflectionClass(Xhprof::class);
        $callAny = $xhprof->getMethod('callAny');
        $callAny->setAccessible(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Neither xhprof nor tideways are installed");
        $callAny->invoke($xhprof, [
            'wfTestCallAny_nosuchfunc1',
            'wfTestCallAny_nosuchfunc2',
            'wfTestCallAny_nosuchfunc3'
        ]);
    }
}

/**
 * Test function #1 for XhprofTest::testCallAny
 * @param int $a
 * @param int $b
 * @return int
 */
function wfTestCallAny_func1($a, $b)
{
    return $a * $b;
}

/**
 * Test function #2 for XhprofTest::testCallAny
 * @param int $a
 * @param int $b
 * @return int
 */
function wfTestCallAny_func2($a, $b)
{
    return $a + $b;
}

/**
 * Test function #3 for XhprofTest::testCallAny
 * @param int $a
 * @param int $b
 * @return int
 */
function wfTestCallAny_func3($a, $b)
{
    return $a - $b;
}
