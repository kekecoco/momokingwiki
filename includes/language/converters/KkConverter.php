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

define('KK_C_UC', 'АӘБВГҒДЕЁЖЗИЙКҚЛМНҢОӨПРСТУҰҮФХҺЦЧШЩЪЫІЬЭЮЯ'); # Kazakh Cyrillic uppercase
define('KK_C_LC', 'аәбвгғдеёжзийкқлмнңоөпрстуұүфхһцчшщъыіьэюя'); # Kazakh Cyrillic lowercase
define('KK_L_UC', 'AÄBCÇDEÉFGĞHIİÏJKLMNÑOÖPQRSŞTUÜVWXYÝZ'); # Kazakh Latin uppercase
define('KK_L_LC', 'aäbcçdeéfgğhıiïjklmnñoöpqrsştuüvwxyýz'); # Kazakh Latin lowercase
// define( 'KK_A', 'ٴابپتجحدرزسشعفقكلمنڭەوۇۋۆىيچھ' ); # Kazakh Arabic
define('H_HAMZA', 'ٴ'); # U+0674 ARABIC LETTER HIGH HAMZA
// define( 'ZWNJ', '‌' ); # U+200C ZERO WIDTH NON-JOINER

/**
 * Kazakh (Қазақша) converter routines
 *
 * @ingroup Languages
 */
class KkConverter extends LanguageConverterSpecific
{

    /**
     * Get Main language code.
     * @return string
     * @since 1.36
     *
     */
    public function getMainCode(): string
    {
        return 'kk';
    }

    /**
     * Get supported variants of the language.
     * @return array
     * @since 1.36
     *
     */
    public function getLanguageVariants(): array
    {
        return [
            'kk',
            'kk-cyrl',
            'kk-latn',
            'kk-arab',
            'kk-kz',
            'kk-tr',
            'kk-cn'
        ];
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
            'kk'      => 'kk-cyrl',
            'kk-cyrl' => 'kk',
            'kk-latn' => 'kk',
            'kk-arab' => 'kk',
            'kk-kz'   => 'kk-cyrl',
            'kk-tr'   => 'kk-latn',
            'kk-cn'   => 'kk-arab'
        ];
    }

    protected function loadDefaultTables()
    {
        // require __DIR__."/../../includes/KkConversion.php";
        // Placeholder for future implementing. Remove variables declarations
        // after generating KkConversion.php
        $kk2Cyrl = [];
        $kk2Latn = [];
        $kk2Arab = [];
        $kk2KZ = [];
        $kk2TR = [];
        $kk2CN = [];

        $this->mTables = [
            'kk-cyrl' => new ReplacementArray($kk2Cyrl),
            'kk-latn' => new ReplacementArray($kk2Latn),
            'kk-arab' => new ReplacementArray($kk2Arab),
            'kk-kz'   => new ReplacementArray(array_merge($kk2Cyrl, $kk2KZ)),
            'kk-tr'   => new ReplacementArray(array_merge($kk2Latn, $kk2TR)),
            'kk-cn'   => new ReplacementArray(array_merge($kk2Arab, $kk2CN)),
            'kk'      => new ReplacementArray()
        ];
    }

    protected function postLoadTables()
    {
        $this->mTables['kk-kz']->merge($this->mTables['kk-cyrl']);
        $this->mTables['kk-tr']->merge($this->mTables['kk-latn']);
        $this->mTables['kk-cn']->merge($this->mTables['kk-arab']);
    }

    /**
     * Return cyrillic to latin reg conversion table
     * @return array
     * @since 1.36
     *
     */
    protected function getMCyrl2Latn(): array
    {
        return [
            # # Punctuation
            '/№/u'                       => 'No.',
            # # Е after vowels
            '/([АӘЕЁИОӨҰҮЭЮЯЪЬ])Е/u'     => '$1YE',
            '/([АӘЕЁИОӨҰҮЭЮЯЪЬ])е/ui'    => '$1ye',
            # # leading ЁЮЯЩ
            '/^Ё([' . KK_C_UC . ']|$)/u' => 'YO$1', '/^Ё([' . KK_C_LC . ']|$)/u' => 'Yo$1',
            '/^Ю([' . KK_C_UC . ']|$)/u' => 'YU$1', '/^Ю([' . KK_C_LC . ']|$)/u' => 'Yu$1',
            '/^Я([' . KK_C_UC . ']|$)/u' => 'YA$1', '/^Я([' . KK_C_LC . ']|$)/u' => 'Ya$1',
            '/^Щ([' . KK_C_UC . ']|$)/u' => 'ŞÇ$1', '/^Щ([' . KK_C_LC . ']|$)/u' => 'Şç$1',
            # # other ЁЮЯ
            '/Ё/u'                       => 'YO', '/ё/u' => 'yo',
            '/Ю/u'                       => 'YU', '/ю/u' => 'yu',
            '/Я/u'                       => 'YA', '/я/u' => 'ya',
            '/Щ/u'                       => 'ŞÇ', '/щ/u' => 'şç',
            # # soft and hard signs
            '/[ъЪ]/u'                    => 'ʺ', '/[ьЬ]/u' => 'ʹ',
            # # other characters
            '/А/u'                       => 'A', '/а/u' => 'a', '/Ә/u' => 'Ä', '/ә/u' => 'ä',
            '/Б/u'                       => 'B', '/б/u' => 'b', '/В/u' => 'V', '/в/u' => 'v',
            '/Г/u'                       => 'G', '/г/u' => 'g', '/Ғ/u' => 'Ğ', '/ғ/u' => 'ğ',
            '/Д/u'                       => 'D', '/д/u' => 'd', '/Е/u' => 'E', '/е/u' => 'e',
            '/Ж/u'                       => 'J', '/ж/u' => 'j', '/З/u' => 'Z', '/з/u' => 'z',
            '/И/u'                       => 'Ï', '/и/u' => 'ï', '/Й/u' => 'Ý', '/й/u' => 'ý',
            '/К/u'                       => 'K', '/к/u' => 'k', '/Қ/u' => 'Q', '/қ/u' => 'q',
            '/Л/u'                       => 'L', '/л/u' => 'l', '/М/u' => 'M', '/м/u' => 'm',
            '/Н/u'                       => 'N', '/н/u' => 'n', '/Ң/u' => 'Ñ', '/ң/u' => 'ñ',
            '/О/u'                       => 'O', '/о/u' => 'o', '/Ө/u' => 'Ö', '/ө/u' => 'ö',
            '/П/u'                       => 'P', '/п/u' => 'p', '/Р/u' => 'R', '/р/u' => 'r',
            '/С/u'                       => 'S', '/с/u' => 's', '/Т/u' => 'T', '/т/u' => 't',
            '/У/u'                       => 'W', '/у/u' => 'w', '/Ұ/u' => 'U', '/ұ/u' => 'u',
            '/Ү/u'                       => 'Ü', '/ү/u' => 'ü', '/Ф/u' => 'F', '/ф/u' => 'f',
            '/Х/u'                       => 'X', '/х/u' => 'x', '/Һ/u' => 'H', '/һ/u' => 'h',
            '/Ц/u'                       => 'C', '/ц/u' => 'c', '/Ч/u' => 'Ç', '/ч/u' => 'ç',
            '/Ш/u'                       => 'Ş', '/ш/u' => 'ş', '/Ы/u' => 'I', '/ы/u' => 'ı',
            '/І/u'                       => 'İ', '/і/u' => 'i', '/Э/u' => 'É', '/э/u' => 'é',
        ];
    }

    /**
     * Return latin to cyrillic reg conversion table
     * @return array
     * @since 1.36
     *
     */
    protected function getMLatn2Cyrl(): array
    {
        return [
            # # Punctuation
            '/#|No\./'                                   => '№',
            # # Şç
            '/ŞÇʹ/u'                                     => 'ЩЬ', '/Şçʹ/u' => 'Щь',
            '/Ş[Çç]/u'                                   => 'Щ', '/şç/u' => 'щ',
            # # soft and hard signs
            '/([' . KK_L_UC . '])ʺ([' . KK_L_UC . '])/u' => '$1Ъ$2',
            '/ʺ([' . KK_L_LC . '])/u'                    => 'ъ$1',
            '/([' . KK_L_UC . '])ʹ([' . KK_L_UC . '])/u' => '$1Ь$2',
            '/ʹ([' . KK_L_LC . '])/u'                    => 'ь$1',
            '/ʺ/u'                                       => 'ъ',
            '/ʹ/u'                                       => 'ь',
            # # Ye Yo Yu Ya.
            '/Y[Ee]/u'                                   => 'Е', '/ye/u' => 'е',
            '/Y[Oo]/u'                                   => 'Ё', '/yo/u' => 'ё',
            '/Y[UWuw]/u'                                 => 'Ю', '/y[uw]/u' => 'ю',
            '/Y[Aa]/u'                                   => 'Я', '/ya/u' => 'я',
            # # other characters
            '/A/u'                                       => 'А', '/a/u' => 'а', '/Ä/u' => 'Ә', '/ä/u' => 'ә',
            '/B/u'                                       => 'Б', '/b/u' => 'б', '/C/u' => 'Ц', '/c/u' => 'ц',
            '/Ç/u'                                       => 'Ч', '/ç/u' => 'ч', '/D/u' => 'Д', '/d/u' => 'д',
            '/E/u'                                       => 'Е', '/e/u' => 'е', '/É/u' => 'Э', '/é/u' => 'э',
            '/F/u'                                       => 'Ф', '/f/u' => 'ф', '/G/u' => 'Г', '/g/u' => 'г',
            '/Ğ/u'                                       => 'Ғ', '/ğ/u' => 'ғ', '/H/u' => 'Һ', '/h/u' => 'һ',
            '/I/u'                                       => 'Ы', '/ı/u' => 'ы', '/İ/u' => 'І', '/i/u' => 'і',
            '/Ï/u'                                       => 'И', '/ï/u' => 'и', '/J/u' => 'Ж', '/j/u' => 'ж',
            '/K/u'                                       => 'К', '/k/u' => 'к', '/L/u' => 'Л', '/l/u' => 'л',
            '/M/u'                                       => 'М', '/m/u' => 'м', '/N/u' => 'Н', '/n/u' => 'н',
            '/Ñ/u'                                       => 'Ң', '/ñ/u' => 'ң', '/O/u' => 'О', '/o/u' => 'о',
            '/Ö/u'                                       => 'Ө', '/ö/u' => 'ө', '/P/u' => 'П', '/p/u' => 'п',
            '/Q/u'                                       => 'Қ', '/q/u' => 'қ', '/R/u' => 'Р', '/r/u' => 'р',
            '/S/u'                                       => 'С', '/s/u' => 'с', '/Ş/u' => 'Ш', '/ş/u' => 'ш',
            '/T/u'                                       => 'Т', '/t/u' => 'т', '/U/u' => 'Ұ', '/u/u' => 'ұ',
            '/Ü/u'                                       => 'Ү', '/ü/u' => 'ү', '/V/u' => 'В', '/v/u' => 'в',
            '/W/u'                                       => 'У', '/w/u' => 'у', '/Ý/u' => 'Й', '/ý/u' => 'й',
            '/X/u'                                       => 'Х', '/x/u' => 'х', '/Z/u' => 'З', '/z/u' => 'з',
        ];
    }

    /**
     * Return latin or cyrillic to arab reg conversion table.
     * @return array
     * @since 1.36
     *
     */
    public function getMCyLa2Arab()
    {
        return [
            # # Punctuation -> Arabic
            '/#|№|No\./u'             => '؀', # U+0600
            '/\,/'                    => '،', # U+060C
            '/;/'                     => '؛', # U+061B
            '/\?/'                    => '؟', # U+061F
            '/%/'                     => '٪', # U+066A
            '/\*/'                    => '٭', # U+066D
            # # Digits -> Arabic
            '/0/'                     => '۰', # U+06F0
            '/1/'                     => '۱', # U+06F1
            '/2/'                     => '۲', # U+06F2
            '/3/'                     => '۳', # U+06F3
            '/4/'                     => '۴', # U+06F4
            '/5/'                     => '۵', # U+06F5
            '/6/'                     => '۶', # U+06F6
            '/7/'                     => '۷', # U+06F7
            '/8/'                     => '۸', # U+06F8
            '/9/'                     => '۹', # U+06F9
            # # Cyrillic -> Arabic
            '/Аллаһ/ui'               => 'ﷲ',
            '/([АӘЕЁИОӨҰҮЭЮЯЪЬ])е/ui' => '$1يە',
            '/[еэ]/ui'                => 'ە', '/[ъь]/ui' => '',
            '/[аә]/ui'                => 'ا', '/[оө]/ui' => 'و', '/[ұү]/ui' => 'ۇ', '/[ыі]/ui' => 'ى',
            '/[и]/ui'                 => 'ىي', '/ё/ui' => 'يو', '/ю/ui' => 'يۋ', '/я/ui' => 'يا', '/[й]/ui' => 'ي',
            '/ц/ui'                   => 'تس', '/щ/ui' => 'شش',
            '/һ/ui'                   => 'ح', '/ч/ui' => 'تش',
            # '/һ/ui' => 'ھ', '/ч/ui' => 'چ',
            '/б/ui'                   => 'ب', '/в/ui' => 'ۆ', '/г/ui' => 'گ', '/ғ/ui' => 'ع',
            '/д/ui'                   => 'د', '/ж/ui' => 'ج', '/з/ui' => 'ز', '/к/ui' => 'ك',
            '/қ/ui'                   => 'ق', '/л/ui' => 'ل', '/м/ui' => 'م', '/н/ui' => 'ن',
            '/ң/ui'                   => 'ڭ', '/п/ui' => 'پ', '/р/ui' => 'ر', '/с/ui' => 'س',
            '/т/ui'                   => 'ت', '/у/ui' => 'ۋ', '/ф/ui' => 'ف', '/х/ui' => 'ح',
            '/ш/ui'                   => 'ش',
            # # Latin -> Arabic // commented for now...
            /*'/Allah/ui' => 'ﷲ',
            '/[eé]/ui' => 'ە', '/[yý]/ui' => 'ي', '/[ʺʹ]/ui' => '',
            '/[aä]/ui' => 'ا', '/[oö]/ui' => 'و', '/[uü]/ui' => 'ۇ',
            '/[ï]/ui' => 'ىي', '/[ıIiİ]/u' => 'ى',
            '/c/ui' => 'تس',
            '/ç/ui' => 'تش', '/h/ui' => 'ح',
            #'/ç/ui' => 'چ', '/h/ui' => 'ھ',
            '/b/ui' => 'ب','/d/ui' => 'د',
            '/f/ui' => 'ف', '/g/ui' => 'گ', '/ğ/ui' => 'ع',
            '/j/ui' => 'ج', '/k/ui' => 'ك', '/l/ui' => 'ل', '/m/ui' => 'م',
            '/n/ui' => 'ن', '/ñ/ui' => 'ڭ', '/p/ui' => 'پ', '/q/ui' => 'ق',
            '/r/ui' => 'ر', '/s/ui' => 'س', '/ş/ui' => 'ش', '/t/ui' => 'ت',
            '/v/ui' => 'ۆ', '/w/ui' => 'ۋ', '/x/ui' => 'ح', '/z/ui' => 'ز',*/
        ];
    }

    /**
     *  It translates text into variant
     *
     * @param string $text
     * @param string $toVariant
     *
     * @return string
     */
    public function translate($text, $toVariant)
    {
        $text = parent::translate($text, $toVariant);

        switch ($toVariant) {
            case 'kk-cyrl':
            case 'kk-kz':
                $letters = KK_L_UC . KK_L_LC . 'ʺʹ#0123456789';
                break;
            case 'kk-latn':
            case 'kk-tr':
                $letters = KK_C_UC . KK_C_LC . '№0123456789';
                break;
            case 'kk-arab':
            case 'kk-cn':
                $letters = KK_C_UC . KK_C_LC . /*KK_L_UC.KK_L_LC.'ʺʹ'.*/
                    ',;\?%\*№0123456789';
                break;
            default:
                return $text;
        }
        // disable conversion variables like $1, $2...
        $varsfix = '\$[0-9]';

        $matches = preg_split(
            '/' . $varsfix . '[^' . $letters . ']+/u',
            $text,
            -1,
            PREG_SPLIT_OFFSET_CAPTURE
        );

        $mstart = 0;
        $ret = '';

        foreach ($matches as $m) {
            $ret .= substr($text, $mstart, (int)$m[1] - $mstart);
            $ret .= $this->regsConverter($m[0], $toVariant);
            $mstart = (int)$m[1] + strlen($m[0]);
        }

        return $ret;
    }

    /**
     * @param string $text
     * @param string $toVariant
     * @return mixed|string
     */
    private function regsConverter($text, $toVariant)
    {
        if ($text == '') {
            return $text;
        }

        switch ($toVariant) {
            case 'kk-arab':
            case 'kk-cn':
                $letters = KK_C_LC . KK_C_UC; /*.KK_L_LC.KK_L_UC*/
                $front = 'әөүіӘӨҮІ'; /*.'äöüiÄÖÜİ'*/
                $excludes = 'еэгғкқЕЭГҒКҚ'; /*.'eégğkqEÉGĞKQ'*/
                // split text to words
                $matches = preg_split('/[\b\s\-\.:]+/', $text, -1, PREG_SPLIT_OFFSET_CAPTURE);
                $mstart = 0;
                $ret = '';
                foreach ($matches as $m) {
                    $ret .= substr($text, $mstart, (int)$m[1] - $mstart);
                    // is matched the word to front vowels?
                    // exclude a words matched to е, э, г, к, к, қ,
                    // them should be without hamza
                    if (preg_match('/[' . $front . ']/u', $m[0]) &&
                        !preg_match('/[' . $excludes . ']/u', $m[0])
                    ) {
                        $ret .= preg_replace('/[' . $letters . ']+/u', H_HAMZA . '$0', $m[0]);
                    } else {
                        $ret .= $m[0];
                    }
                    $mstart = (int)$m[1] + strlen($m[0]);
                }
                $text =& $ret;
                $mCyLa2Arab = $this->getMCyLa2Arab();
                foreach ($mCyLa2Arab as $pat => $rep) {
                    $text = preg_replace($pat, $rep, $text);
                }

                return $text;
            case 'kk-latn':
            case 'kk-tr':
                $mCyrl2Latn = $this->getMCyrl2Latn();
                foreach ($mCyrl2Latn as $pat => $rep) {
                    $text = preg_replace($pat, $rep, $text);
                }

                return $text;
            case 'kk-cyrl':
            case 'kk-kz':
                $mLatn2Cyrl = $this->getMLatn2Cyrl();
                foreach ($mLatn2Cyrl as $pat => $rep) {
                    $text = preg_replace($pat, $rep, $text);
                }

                return $text;
            default:
                return $text;
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public function convertCategoryKey($key)
    {
        return $this->autoConvert($key, 'kk');
    }
}
