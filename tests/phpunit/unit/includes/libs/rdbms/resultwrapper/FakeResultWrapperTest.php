<?php

/**
 * Holds tests for FakeResultWrapper MediaWiki class.
 *
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

use Wikimedia\Rdbms\FakeResultWrapper;

/**
 * @covers \Wikimedia\Rdbms\FakeResultWrapper
 */
class FakeResultWrapperTest extends PHPUnit\Framework\TestCase
{
    public function testIteration()
    {
        $res = new FakeResultWrapper([
            ['colA' => 1, 'colB' => 'a'],
            ['colA' => 2, 'colB' => 'b'],
            (object)['colA' => 3, 'colB' => 'c'],
            ['colA' => 4, 'colB' => 'd'],
            ['colA' => 5, 'colB' => 'e'],
            (object)['colA' => 6, 'colB' => 'f'],
            (object)['colA' => 7, 'colB' => 'g'],
            ['colA' => 8, 'colB' => 'h']
        ]);

        $expectedRows = [
            0 => (object)['colA' => 1, 'colB' => 'a'],
            1 => (object)['colA' => 2, 'colB' => 'b'],
            2 => (object)['colA' => 3, 'colB' => 'c'],
            3 => (object)['colA' => 4, 'colB' => 'd'],
            4 => (object)['colA' => 5, 'colB' => 'e'],
            5 => (object)['colA' => 6, 'colB' => 'f'],
            6 => (object)['colA' => 7, 'colB' => 'g'],
            7 => (object)['colA' => 8, 'colB' => 'h']
        ];

        $this->assertEquals(8, $res->numRows());

        $res->seek(7);
        $this->assertEquals(['colA' => 8, 'colB' => 'h'], $res->fetchRow());
        $res->seek(7);
        $this->assertEquals((object)['colA' => 8, 'colB' => 'h'], $res->fetchObject());

        $this->assertEquals($expectedRows, iterator_to_array($res, true));

        $rows = [];
        foreach ($res as $i => $row) {
            $rows[$i] = $row;
        }
        $this->assertEquals($expectedRows, $rows);
    }
}
