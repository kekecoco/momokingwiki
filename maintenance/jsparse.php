<?php
/**
 * Test JavaScript validity parses using jsmin+'s parser
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
 * @ingroup Maintenance
 */

use Wikimedia\AtEase\AtEase;

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script to test JavaScript validity using JsMinPlus' parser
 *
 * @ingroup Maintenance
 */
class JSParseHelper extends Maintenance
{
    public $errs = 0;

    public function __construct()
    {
        parent::__construct();
        $this->addDescription('Runs parsing/syntax checks on JavaScript files');
        $this->addArg('file(s)', 'JavaScript file to test', false);
    }

    public function execute()
    {
        if (!$this->hasArg(0)) {
            $this->maybeHelp(true);
        }
        $files = $this->mArgs;

        $parser = new JSParser();
        foreach ($files as $filename) {
            AtEase::suppressWarnings();
            $js = file_get_contents($filename);
            AtEase::restoreWarnings();
            if ($js === false) {
                $this->output("$filename ERROR: could not read file\n");
                $this->errs++;
                continue;
            }

            try {
                $parser->parse($js, $filename, 1);
            } catch (Exception $e) {
                $this->errs++;
                $this->output("$filename ERROR: " . $e->getMessage() . "\n");
                continue;
            }

            $this->output("$filename OK\n");
        }

        if ($this->errs > 0) {
            $this->fatalError('Failed.');
        }
    }
}

$maintClass = JSParseHelper::class;
require_once RUN_MAINTENANCE_IF_MAIN;
