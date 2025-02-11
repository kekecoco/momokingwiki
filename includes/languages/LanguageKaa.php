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

use MediaWiki\MainConfigNames;
use MediaWiki\MediaWikiServices;

/**
 * Karakalpak (Qaraqalpaqsha)
 *
 * @ingroup Languages
 */
class LanguageKaa extends Language
{

    # Convert from the nominative form of a noun to some other case
    # Invoked with {{GRAMMAR:case|word}}

    /**
     * Cases: genitive, dative, accusative, locative, ablative, comitative + possessive forms
     *
     * @param string $word
     * @param string $case
     *
     * @return string
     */
    public function convertGrammar($word, $case)
    {
        $grammarForms =
            MediaWikiServices::getInstance()->getMainConfig()->get(MainConfigNames::GrammarForms);
        if (isset($grammarForms['kaa'][$case][$word])) {
            return $grammarForms['kaa'][$case][$word];
        }

        /* Full code of function convertGrammar() is in development. Updates coming soon. */

        return $word;
    }

    /**
     * It fixes issue with ucfirst for transforming 'i' to 'İ'
     *
     * @param string $string
     *
     * @return string
     */
    public function ucfirst($string)
    {
        if (substr($string, 0, 1) === 'i') {
            return 'İ' . substr($string, 1);
        }

        return parent::ucfirst($string);
    }

    /**
     * It fixes issue with lcfirst for transforming 'I' to 'ı'
     *
     * @param string $string
     *
     * @return mixed|string
     */
    public function lcfirst($string)
    {
        if (substr($string, 0, 1) === 'I') {
            return 'ı' . substr($string, 1);
        }

        return parent::lcfirst($string);
    }

}
