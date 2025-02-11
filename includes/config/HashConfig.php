<?php
/**
 * Copyright 2014
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

use MediaWiki\Config\IterableConfig;

/**
 * A Config instance which stores all settings as a member variable
 *
 * @since 1.24
 */
class HashConfig implements Config, MutableConfig, IterableConfig
{

    /**
     * Array of config settings
     *
     * @var array
     */
    private $settings;

    /**
     * @return HashConfig
     */
    public static function newInstance()
    {
        return new HashConfig;
    }

    /**
     * @param array $settings Any current settings to pre-load
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @inheritDoc
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new ConfigException(__METHOD__ . ": undefined option: '$name'");
        }

        return $this->settings[$name];
    }

    /**
     * @inheritDoc
     * @since 1.24
     */
    public function has($name)
    {
        return array_key_exists($name, $this->settings);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @see MutableConfig::set
     */
    public function set($name, $value)
    {
        $this->settings[$name] = $value;
    }

    /**
     * @inheritDoc
     * @return Traversable
     * @since 1.38
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->settings);
    }

    /**
     * @inheritDoc
     * @return string[]
     * @since 1.38
     */
    public function getNames(): array
    {
        return array_keys($this->settings);
    }

    /**
     * Clears all config variables.
     * @since 1.39
     */
    public function clear()
    {
        $this->settings = [];
    }
}
