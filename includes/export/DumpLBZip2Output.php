<?php
/**
 * Sends dump output via the lbzip2 compressor.
 *
 * Copyright © 2003, 2005, 2006 Brion Vibber <brion@pobox.com>
 * Copyright © 2019 Wikimedia Foundation Inc.
 * https://www.mediawiki.org/
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
 * @since 1.33
 */
class DumpLBZip2Output extends DumpPipeOutput
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        # use only one core
        parent::__construct("lbzip2 -n 1", $file);
    }
}
