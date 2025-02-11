<?php
/**
 * Stream outputter that buffers and returns data as a string.
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

/**
 * @ingroup Dump
 * @since 1.28
 */
class DumpStringOutput extends DumpOutput
{
    /** @var string */
    private $output = '';

    /**
     * @param string $string
     */
    public function write($string)
    {
        $this->output .= $string;
    }

    /**
     * Get the string containing the output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->output;
    }
}
