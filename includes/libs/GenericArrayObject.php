<?php

/**
 * Extends ArrayObject and does two things:
 *
 * Allows for deriving classes to easily intercept additions
 * and deletions for purposes such as additional indexing.
 *
 * Enforces the objects to be of a certain type, so this
 * can be replied upon, much like if this had true support
 * for generics, which sadly enough is not possible in PHP.
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
 * @since 1.20
 *
 * @file
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class GenericArrayObject extends ArrayObject
{
    /**
     * Returns the name of an interface/class that the element should implement/extend.
     *
     * @return string
     * @since 1.20
     *
     */
    abstract public function getObjectType();

    /**
     * @see SiteList::getNewOffset()
     * @since 1.20
     * @var int
     */
    protected $indexOffset = 0;

    /**
     * Finds a new offset for when appending an element.
     * The base class does this, so it would be better to integrate,
     * but there does not appear to be any way to do this...
     *
     * @return int
     * @since 1.20
     *
     */
    protected function getNewOffset()
    {
        while ($this->offsetExists($this->indexOffset)) {
            $this->indexOffset++;
        }

        return $this->indexOffset;
    }

    /**
     * @param null|array $input
     * @param int $flags
     * @param string $iterator_class
     * @since 1.20
     *
     * @see ArrayObject::__construct
     *
     */
    public function __construct($input = null, $flags = 0, $iterator_class = 'ArrayIterator')
    {
        parent::__construct([], $flags, $iterator_class);

        if ($input !== null) {
            foreach ($input as $offset => $value) {
                $this->offsetSet($offset, $value);
            }
        }
    }

    /**
     * @param mixed $value
     * @since 1.20
     *
     * @see ArrayObject::append
     *
     */
    public function append($value): void
    {
        $this->setElement(null, $value);
    }

    /**
     * @param mixed $index
     * @param mixed $value
     * @see ArrayObject::offsetSet()
     *
     * @since 1.20
     *
     */
    public function offsetSet($index, $value): void
    {
        $this->setElement($index, $value);
    }

    /**
     * Returns if the provided value has the same type as the elements
     * that can be added to this ArrayObject.
     *
     * @param mixed $value
     *
     * @return bool
     * @since 1.20
     *
     */
    protected function hasValidType($value)
    {
        $class = $this->getObjectType();

        return $value instanceof $class;
    }

    /**
     * Method that actually sets the element and holds
     * all common code needed for set operations, including
     * type checking and offset resolving.
     *
     * If you want to do additional indexing or have code that
     * otherwise needs to be executed whenever an element is added,
     * you can overload @param mixed $index
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     * @since 1.20
     *
     * @see preSetElement.
     *
     */
    protected function setElement($index, $value)
    {
        if (!$this->hasValidType($value)) {
            throw new InvalidArgumentException(
                'Can only add ' . $this->getObjectType() . ' implementing objects to '
                . static::class . '.'
            );
        }

        if ($index === null) {
            $index = $this->getNewOffset();
        }

        if ($this->preSetElement($index, $value)) {
            parent::offsetSet($index, $value);
        }
    }

    /**
     * Gets called before a new element is added to the ArrayObject.
     *
     * At this point the index is always set (ie not null) and the
     * value is always of the type returned by @param int|string $index
     * @param mixed $value
     *
     * @return bool
     * @since 1.20
     *
     * @see getObjectType.
     *
     * Should return a boolean. When false is returned the element
     * does not get added to the ArrayObject.
     *
     */
    protected function preSetElement($index, $value)
    {
        return true;
    }

    /**
     * @return string
     * @since 1.20
     *
     * @see Serializable::serialize
     *
     */
    public function serialize(): string
    {
        return serialize($this->__serialize());
    }

    /**
     * @return array
     * @since 1.38
     *
     * @see Serializable::serialize
     *
     */
    public function __serialize(): array
    {
        return $this->getSerializationData();
    }

    /**
     * Returns an array holding all the data that should go into serialization calls.
     * This is intended to allow overloading without having to reimplement the
     * behavior of this base class.
     *
     * @return array
     * @since 1.20
     *
     */
    protected function getSerializationData()
    {
        return [
            'data'  => $this->getArrayCopy(),
            'index' => $this->indexOffset,
        ];
    }

    /**
     * @param string $serialization
     * @since 1.20
     *
     * @see Serializable::unserialize
     *
     */
    public function unserialize($serialization): void
    {
        $this->__unserialize(unserialize($serialization));
    }

    /**
     * @param array $serializationData
     * @since 1.38
     *
     * @see Serializable::unserialize
     *
     */
    public function __unserialize($serializationData): void
    {
        foreach ($serializationData['data'] as $offset => $value) {
            // Just set the element, bypassing checks and offset resolving,
            // as these elements have already gone through this.
            parent::offsetSet($offset, $value);
        }

        $this->indexOffset = $serializationData['index'];
    }

    /**
     * Returns if the ArrayObject has no elements.
     *
     * @return bool
     * @since 1.20
     *
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }
}
