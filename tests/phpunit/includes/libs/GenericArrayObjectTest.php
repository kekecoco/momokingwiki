<?php

/**
 * Tests for the GenericArrayObject and deriving classes.
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
 * @since 1.20
 *
 * @ingroup Test
 * @group GenericArrayObject
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class GenericArrayObjectTest extends PHPUnit\Framework\TestCase
{

    use MediaWikiCoversValidator;

    /**
     * Returns objects that can serve as elements in the concrete
     * GenericArrayObject deriving class being tested.
     *
     * @return array
     * @since 1.20
     *
     */
    abstract public function elementInstancesProvider();

    /**
     * Returns the name of the concrete class being tested.
     *
     * @return string
     * @since 1.20
     *
     */
    abstract public function getInstanceClass();

    /**
     * Provides instances of the concrete class being tested.
     *
     * @return array
     * @since 1.20
     *
     */
    public function instanceProvider()
    {
        $instances = [];

        foreach ($this->elementInstancesProvider() as $elementInstances) {
            $instances[] = $this->getNew($elementInstances[0]);
        }

        return $this->arrayWrap($instances);
    }

    /**
     * @param array $elements
     *
     * @return GenericArrayObject
     * @since 1.20
     *
     */
    protected function getNew(array $elements = [])
    {
        $class = $this->getInstanceClass();

        return new $class($elements);
    }

    /**
     * @dataProvider elementInstancesProvider
     *
     * @param array $elements
     *
     * @covers       GenericArrayObject::__construct
     * @since 1.20
     *
     */
    public function testConstructor(array $elements)
    {
        $arrayObject = $this->getNew($elements);

        $this->assertEquals(count($elements), $arrayObject->count());
    }

    /**
     * @dataProvider elementInstancesProvider
     *
     * @param array $elements
     *
     * @covers       GenericArrayObject::isEmpty
     * @since 1.20
     *
     */
    public function testIsEmpty(array $elements)
    {
        $arrayObject = $this->getNew($elements);

        $this->assertEquals($elements === [], $arrayObject->isEmpty());
    }

    /**
     * @dataProvider instanceProvider
     *
     * @param GenericArrayObject $list
     *
     * @covers       GenericArrayObject::offsetUnset
     * @since 1.20
     *
     */
    public function testUnset(GenericArrayObject $list)
    {
        if ($list->isEmpty()) {
            $this->assertTrue(true); // We cannot test unset if there are no elements
        } else {
            $offset = $list->getIterator()->key();
            $count = $list->count();
            $list->offsetUnset($offset);
            $this->assertEquals($count - 1, $list->count());
        }

        if (!$list->isEmpty()) {
            $offset = $list->getIterator()->key();
            $count = $list->count();
            unset($list[$offset]);
            $this->assertEquals($count - 1, $list->count());
        }
    }

    /**
     * @dataProvider elementInstancesProvider
     *
     * @param array $elements
     *
     * @covers       GenericArrayObject::append
     * @since 1.20
     *
     */
    public function testAppend(array $elements)
    {
        $list = $this->getNew();

        $listSize = count($elements);

        foreach ($elements as $element) {
            $list->append($element);
        }

        $this->assertEquals($listSize, $list->count());

        $list = $this->getNew();

        foreach ($elements as $element) {
            $list[] = $element;
        }

        $this->assertEquals($listSize, $list->count());

        $this->checkTypeChecks(static function (GenericArrayObject $list, $element) {
            $list->append($element);
        });
    }

    /**
     * @param callable $function
     * @since 1.20
     *
     */
    protected function checkTypeChecks($function)
    {
        $excption = null;
        $list = $this->getNew();

        $elementClass = $list->getObjectType();

        foreach ([42, 'foo', [], (object)[], 4.2] as $element) {
            $validValid = $element instanceof $elementClass;

            try {
                $function($list, $element);
                $valid = true;
            } catch (InvalidArgumentException $exception) {
                $valid = false;
            }

            $this->assertEquals(
                $validValid,
                $valid,
                'Object of invalid type got successfully added to a GenericArrayObject'
            );
        }
    }

    /**
     * @dataProvider elementInstancesProvider
     *
     * @param array $elements
     * @covers       GenericArrayObject::getObjectType
     * @covers       GenericArrayObject::offsetSet
     * @since 1.20
     *
     */
    public function testOffsetSet(array $elements)
    {
        if ($elements === []) {
            $this->assertTrue(true);

            return;
        }

        $list = $this->getNew();

        $element = reset($elements);
        $list->offsetSet(42, $element);
        $this->assertEquals($element, $list->offsetGet(42));

        $list = $this->getNew();

        $element = reset($elements);
        $list['oHai'] = $element;
        $this->assertEquals($element, $list['oHai']);

        $list = $this->getNew();

        $element = reset($elements);
        $list->offsetSet(9001, $element);
        $this->assertEquals($element, $list[9001]);

        $list = $this->getNew();

        $element = reset($elements);
        $list->offsetSet(null, $element);
        $this->assertEquals($element, $list[0]);

        $list = $this->getNew();
        $offset = 0;

        foreach ($elements as $element) {
            $list->offsetSet(null, $element);
            $this->assertEquals($element, $list[$offset++]);
        }

        $this->assertEquals(count($elements), $list->count());

        $this->checkTypeChecks(static function (GenericArrayObject $list, $element) {
            $list->offsetSet(mt_rand(), $element);
        });
    }

    /**
     * @dataProvider instanceProvider
     *
     * @param GenericArrayObject $list
     *
     * @covers       GenericArrayObject::getSerializationData
     * @covers       GenericArrayObject::serialize
     * @covers       GenericArrayObject::unserialize
     * @since 1.21
     *
     */
    public function testSerialization(GenericArrayObject $list)
    {
        $serialization = serialize($list);
        $copy = unserialize($serialization);

        $this->assertEquals($serialization, serialize($copy));
        $this->assertSame(count($list), count($copy));

        $list = $list->getArrayCopy();
        $copy = $copy->getArrayCopy();

        $this->assertArrayEquals($list, $copy, true, true);
    }
}
