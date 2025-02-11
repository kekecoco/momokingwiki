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
 * English specific converter routines.
 *
 * @ingroup Languages
 */
class EnConverter extends LanguageConverter
{

    /**
     * Get Main language code.
     * @return string
     * @since 1.36
     *
     */
    public function getMainCode(): string
    {
        return 'en';
    }

    /**
     * Get supported variants of the language.
     * @return array
     * @since 1.36
     *
     */
    public function getLanguageVariants(): array
    {
        return ['en', 'en-x-piglatin'];
    }

    /**
     * Get language variants fallbacks.
     * @return array
     * @since 1.36
     *
     */
    public function getVariantsFallbacks(): array
    {
        return [];
    }

    protected function loadDefaultTables()
    {
        $this->mTables = [
            'en'            => new ReplacementArray(),
            'en-x-piglatin' => new ReplacementArray(),
        ];
    }

    /**
     * Translates text into Pig Latin. This allows developers to test the language variants
     * functionality and user interface without having to switch wiki language away from default.
     *
     * @param string $text
     * @param string $toVariant
     * @return string
     */
    public function translate($text, $toVariant)
    {
        if ($toVariant !== 'en-x-piglatin') {
            return $text;
        }

        // Only process words composed of standard English alphabet, leave the rest unchanged.
        // This skips some English words like 'naïve' or 'résumé', but we can live with that.
        // Ignore single letters and words which aren't lowercase or uppercase-first.
        return preg_replace_callback('/[A-Za-z][a-z\']+/', static function ($matches) {
            $word = $matches[0];
            if (preg_match('/^[aeiou]/i', $word)) {
                return $word . 'way';
            }

            return preg_replace_callback('/^(s?qu|[^aeiou][^aeiouy]*)(.*)$/i', static function ($m) {
                $ucfirst = strtoupper($m[1][0]) === $m[1][0];
                if ($ucfirst) {
                    return ucfirst($m[2]) . lcfirst($m[1]) . 'ay';
                }

                return $m[2] . $m[1] . 'ay';
            }, $word);
        }, $text);
    }
}
