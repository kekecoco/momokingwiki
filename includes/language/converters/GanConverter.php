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
 * Gan Chinese specific code.
 *
 * @ingroup Languages
 */
class GanConverter extends LanguageConverter
{

    /**
     * Get Main language code.
     * @return string
     * @since 1.36
     *
     */
    public function getMainCode(): string
    {
        return 'gan';
    }

    /**
     * Get supported variants of the language.
     * @return array
     * @since 1.36
     *
     */
    public function getLanguageVariants(): array
    {
        return ['gan', 'gan-hans', 'gan-hant'];
    }

    /**
     * Get language variants fallbacks.
     * @return array
     * @since 1.36
     *
     */
    public function getVariantsFallbacks(): array
    {
        return [
            'gan'      => ['gan-hans', 'gan-hant'],
            'gan-hans' => ['gan'],
            'gan-hant' => ['gan'],
        ];
    }

    /**
     * Get manual level limit for supported variants.
     * @return array
     * @since 1.36
     *
     */
    protected function getAdditionalManualLevel(): array
    {
        return ['gan' => 'disable'];
    }

    /**
     * Get desc. code separator.
     * @return string
     * @since 1.36
     *
     */
    public function getDescCodeSeparator(): string
    {
        return ': ';
    }

    /**
     * Get desc. var separator.
     * @return string
     * @since 1.36
     *
     */
    public function getDescVarSeparator(): string
    {
        return '; ';
    }

    /**
     * Get variant names. Overrides parent's implementation
     * @return array
     * @since 1.36
     *
     */
    public function getVariantNames(): array
    {
        $names = [
            'gan'      => '原文',
            'gan-hans' => '简体',
            'gan-hant' => '繁體',
        ];

        return array_merge(parent::getVariantNames(), $names);
    }

    protected function loadDefaultTables()
    {
        $this->mTables = [
            'gan-hans' => new ReplacementArray(MediaWiki\Languages\Data\ZhConversion::$zh2Hans),
            'gan-hant' => new ReplacementArray(MediaWiki\Languages\Data\ZhConversion::$zh2Hant),
            'gan'      => new ReplacementArray
        ];
    }

    /**
     * @param string $key
     * @return string
     */
    public function convertCategoryKey($key)
    {
        return $this->autoConvert($key, 'gan');
    }
}
