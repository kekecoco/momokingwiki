<?php
/**
 * Extraction and validation of image metadata.
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
 * @ingroup Media
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason, 2009 Brent Garber
 * @license GPL-2.0-or-later
 * @see http://exif.org/Exif2-2.PDF The Exif 2.2 specification
 * @file
 */

use Wikimedia\AtEase\AtEase;

/**
 * Class to extract and validate Exif data from jpeg (and possibly tiff) files.
 * @ingroup Media
 */
class Exif
{
    /** An 8-bit (1-byte) unsigned integer. */
    private const BYTE = 1;

    /** An 8-bit byte containing one 7-bit ASCII code.
     *  The final byte is terminated with NULL.
     */
    private const ASCII = 2;

    /** A 16-bit (2-byte) unsigned integer. */
    private const SHORT = 3;

    /** A 32-bit (4-byte) unsigned integer. */
    private const LONG = 4;

    /** Two LONGs. The first LONG is the numerator and the second LONG expresses
     *  the denominator
     */
    private const RATIONAL = 5;

    /** A 16-bit (2-byte) or 32-bit (4-byte) unsigned integer. */
    private const SHORT_OR_LONG = 6;

    /** An 8-bit byte that can take any value depending on the field definition */
    private const UNDEFINED = 7;

    /** A 32-bit (4-byte) signed integer (2's complement notation), */
    private const SLONG = 9;

    /** Two SLONGs. The first SLONG is the numerator and the second SLONG is
     *  the denominator.
     */
    private const SRATIONAL = 10;

    /** A fake value for things we don't want or don't support. */
    private const IGNORE = -1;

    /** @var array Exif tags grouped by category, the tagname itself is the key
     *    and the type is the value, in the case of more than one possible value
     *    type they are separated by commas.
     */
    private $mExifTags;

    /** @var array The raw Exif data returned by exif_read_data() */
    private $mRawExifData;

    /** @var array A Filtered version of $mRawExifData that has been pruned
     *    of invalid tags and tags that contain content they shouldn't contain
     *    according to the Exif specification
     */
    private $mFilteredExifData;

    /** @var string The file being processed */
    private $file;

    /** @var string The basename of the file being processed */
    private $basename;

    /** @var string|false The private log to log to, e.g. 'exif' */
    private $log = false;

    /** @var string The byte order of the file. Needed because php's extension
     *    doesn't fully process some obscure props.
     */
    private $byteOrder;

    /**
     * @param string $file Filename.
     * @param string $byteOrder Type of byte ordering either 'BE' (Big Endian)
     *   or 'LE' (Little Endian). Default ''.
     * @throws MWException
     * @todo FIXME: The following are broke:
     *   SubjectArea. Need to test the more obscure tags.
     *   DigitalZoomRatio = 0/0 is rejected. need to determine if that's valid.
     *   Possibly should treat 0/0 = 0. need to read exif spec on that.
     */
    public function __construct($file, $byteOrder = '')
    {
        /**
         * Page numbers here refer to pages in the Exif 2.2 standard
         *
         * Note, Exif::UNDEFINED is treated as a string, not as an array of bytes
         * so don't put a count parameter for any UNDEFINED values.
         *
         * @link http://exif.org/Exif2-2.PDF The Exif 2.2 specification
         */
        $this->mExifTags = [
            # TIFF Rev. 6.0 Attribute Information (p22)
            'IFD0' => [
                # Tags relating to image structure
                'ImageWidth'                  => self::SHORT_OR_LONG, # Image width
                'ImageLength'                 => self::SHORT_OR_LONG, # Image height
                'BitsPerSample'               => [self::SHORT, 3], # Number of bits per component
                # "When a primary image is JPEG compressed, this designation is not"
                # "necessary and is omitted." (p23)
                'Compression'                 => self::SHORT, # Compression scheme #p23
                'PhotometricInterpretation'   => self::SHORT, # Pixel composition #p23
                'Orientation'                 => self::SHORT, # Orientation of image #p24
                'SamplesPerPixel'             => self::SHORT, # Number of components
                'PlanarConfiguration'         => self::SHORT, # Image data arrangement #p24
                'YCbCrSubSampling'            => [self::SHORT, 2], # Subsampling ratio of Y to C #p24
                'YCbCrPositioning'            => self::SHORT, # Y and C positioning #p24-25
                'XResolution'                 => self::RATIONAL, # Image resolution in width direction
                'YResolution'                 => self::RATIONAL, # Image resolution in height direction
                'ResolutionUnit'              => self::SHORT, # Unit of X and Y resolution #(p26)

                # Tags relating to recording offset
                'StripOffsets'                => self::SHORT_OR_LONG, # Image data location
                'RowsPerStrip'                => self::SHORT_OR_LONG, # Number of rows per strip
                'StripByteCounts'             => self::SHORT_OR_LONG, # Bytes per compressed strip
                'JPEGInterchangeFormat'       => self::SHORT_OR_LONG, # Offset to JPEG SOI
                'JPEGInterchangeFormatLength' => self::SHORT_OR_LONG, # Bytes of JPEG data

                # Tags relating to image data characteristics
                'TransferFunction'            => self::IGNORE, # Transfer function
                'WhitePoint'                  => [self::RATIONAL, 2], # White point chromaticity
                'PrimaryChromaticities'       => [self::RATIONAL, 6], # Chromaticities of primarities
                # Color space transformation matrix coefficients #p27
                'YCbCrCoefficients'           => [self::RATIONAL, 3],
                'ReferenceBlackWhite'         => [self::RATIONAL, 6], # Pair of black and white reference values

                # Other tags
                'DateTime'                    => self::ASCII, # File change date and time
                'ImageDescription'            => self::ASCII, # Image title
                'Make'                        => self::ASCII, # Image input equipment manufacturer
                'Model'                       => self::ASCII, # Image input equipment model
                'Software'                    => self::ASCII, # Software used
                'Artist'                      => self::ASCII, # Person who created the image
                'Copyright'                   => self::ASCII, # Copyright holder
            ],

            # Exif IFD Attribute Information (p30-31)
            'EXIF' => [
                # @todo NOTE: Nonexistence of this field is taken to mean nonconformance
                # to the Exif 2.1 AND 2.2 standards
                'ExifVersion'              => self::UNDEFINED, # Exif version
                'FlashPixVersion'          => self::UNDEFINED, # Supported Flashpix version #p32

                # Tags relating to Image Data Characteristics
                'ColorSpace'               => self::SHORT, # Color space information #p32

                # Tags relating to image configuration
                'ComponentsConfiguration'  => self::UNDEFINED, # Meaning of each component #p33
                'CompressedBitsPerPixel'   => self::RATIONAL, # Image compression mode
                'PixelYDimension'          => self::SHORT_OR_LONG, # Valid image height
                'PixelXDimension'          => self::SHORT_OR_LONG, # Valid image width

                # Tags relating to related user information
                'MakerNote'                => self::IGNORE, # Manufacturer notes
                'UserComment'              => self::UNDEFINED, # User comments #p34

                # Tags relating to related file information
                'RelatedSoundFile'         => self::ASCII, # Related audio file

                # Tags relating to date and time
                'DateTimeOriginal'         => self::ASCII, # Date and time of original data generation #p36
                'DateTimeDigitized'        => self::ASCII, # Date and time of original data generation
                'SubSecTime'               => self::ASCII, # DateTime subseconds
                'SubSecTimeOriginal'       => self::ASCII, # DateTimeOriginal subseconds
                'SubSecTimeDigitized'      => self::ASCII, # DateTimeDigitized subseconds

                # Tags relating to picture-taking conditions (p31)
                'ExposureTime'             => self::RATIONAL, # Exposure time
                'FNumber'                  => self::RATIONAL, # F Number
                'ExposureProgram'          => self::SHORT, # Exposure Program #p38
                'SpectralSensitivity'      => self::ASCII, # Spectral sensitivity
                'ISOSpeedRatings'          => self::SHORT, # ISO speed rating
                'OECF'                     => self::IGNORE,
                # Optoelectronic conversion factor. Note: We don't have support for this atm.
                'ShutterSpeedValue'        => self::SRATIONAL, # Shutter speed
                'ApertureValue'            => self::RATIONAL, # Aperture
                'BrightnessValue'          => self::SRATIONAL, # Brightness
                'ExposureBiasValue'        => self::SRATIONAL, # Exposure bias
                'MaxApertureValue'         => self::RATIONAL, # Maximum land aperture
                'SubjectDistance'          => self::RATIONAL, # Subject distance
                'MeteringMode'             => self::SHORT, # Metering mode #p40
                'LightSource'              => self::SHORT, # Light source #p40-41
                'Flash'                    => self::SHORT, # Flash #p41-42
                'FocalLength'              => self::RATIONAL, # Lens focal length
                'SubjectArea'              => [self::SHORT, 4], # Subject area
                'FlashEnergy'              => self::RATIONAL, # Flash energy
                'SpatialFrequencyResponse' => self::IGNORE, # Spatial frequency response. Not supported atm.
                'FocalPlaneXResolution'    => self::RATIONAL, # Focal plane X resolution
                'FocalPlaneYResolution'    => self::RATIONAL, # Focal plane Y resolution
                'FocalPlaneResolutionUnit' => self::SHORT, # Focal plane resolution unit #p46
                'SubjectLocation'          => [self::SHORT, 2], # Subject location
                'ExposureIndex'            => self::RATIONAL, # Exposure index
                'SensingMethod'            => self::SHORT, # Sensing method #p46
                'FileSource'               => self::UNDEFINED, # File source #p47
                'SceneType'                => self::UNDEFINED, # Scene type #p47
                'CFAPattern'               => self::IGNORE, # CFA pattern. not supported atm.
                'CustomRendered'           => self::SHORT, # Custom image processing #p48
                'ExposureMode'             => self::SHORT, # Exposure mode #p48
                'WhiteBalance'             => self::SHORT, # White Balance #p49
                'DigitalZoomRatio'         => self::RATIONAL, # Digital zoom ration
                'FocalLengthIn35mmFilm'    => self::SHORT, # Focal length in 35 mm film
                'SceneCaptureType'         => self::SHORT, # Scene capture type #p49
                'GainControl'              => self::SHORT, # Scene control #p49-50
                'Contrast'                 => self::SHORT, # Contrast #p50
                'Saturation'               => self::SHORT, # Saturation #p50
                'Sharpness'                => self::SHORT, # Sharpness #p50
                'DeviceSettingDescription' => self::IGNORE,
                # Device settings description. This could maybe be supported. Need to find an
                # example file that uses this to see if it has stuff of interest in it.
                'SubjectDistanceRange'     => self::SHORT, # Subject distance range #p51

                'ImageUniqueID' => self::ASCII, # Unique image ID
            ],

            # GPS Attribute Information (p52)
            'GPS'  => [
                'GPSVersion'          => self::UNDEFINED,
                # Should be an array of 4 Exif::BYTE's. However php treats it as an undefined
                # Note exif standard calls this GPSVersionID, but php doesn't like the id suffix
                'GPSLatitudeRef'      => self::ASCII, # North or South Latitude #p52-53
                'GPSLatitude'         => [self::RATIONAL, 3], # Latitude
                'GPSLongitudeRef'     => self::ASCII, # East or West Longitude #p53
                'GPSLongitude'        => [self::RATIONAL, 3], # Longitude
                'GPSAltitudeRef'      => self::UNDEFINED,
                # Altitude reference. Note, the exif standard says this should be an EXIF::Byte,
                # but php seems to disagree.
                'GPSAltitude'         => self::RATIONAL, # Altitude
                'GPSTimeStamp'        => [self::RATIONAL, 3], # GPS time (atomic clock)
                'GPSSatellites'       => self::ASCII, # Satellites used for measurement
                'GPSStatus'           => self::ASCII, # Receiver status #p54
                'GPSMeasureMode'      => self::ASCII, # Measurement mode #p54-55
                'GPSDOP'              => self::RATIONAL, # Measurement precision
                'GPSSpeedRef'         => self::ASCII, # Speed unit #p55
                'GPSSpeed'            => self::RATIONAL, # Speed of GPS receiver
                'GPSTrackRef'         => self::ASCII, # Reference for direction of movement #p55
                'GPSTrack'            => self::RATIONAL, # Direction of movement
                'GPSImgDirectionRef'  => self::ASCII, # Reference for direction of image #p56
                'GPSImgDirection'     => self::RATIONAL, # Direction of image
                'GPSMapDatum'         => self::ASCII, # Geodetic survey data used
                'GPSDestLatitudeRef'  => self::ASCII, # Reference for latitude of destination #p56
                'GPSDestLatitude'     => [self::RATIONAL, 3], # Latitude destination
                'GPSDestLongitudeRef' => self::ASCII, # Reference for longitude of destination #p57
                'GPSDestLongitude'    => [self::RATIONAL, 3], # Longitude of destination
                'GPSDestBearingRef'   => self::ASCII, # Reference for bearing of destination #p57
                'GPSDestBearing'      => self::RATIONAL, # Bearing of destination
                'GPSDestDistanceRef'  => self::ASCII, # Reference for distance to destination #p57-58
                'GPSDestDistance'     => self::RATIONAL, # Distance to destination
                'GPSProcessingMethod' => self::UNDEFINED, # Name of GPS processing method
                'GPSAreaInformation'  => self::UNDEFINED, # Name of GPS area
                'GPSDateStamp'        => self::ASCII, # GPS date
                'GPSDifferential'     => self::SHORT, # GPS differential correction
            ],
        ];

        $this->file = $file;
        $this->basename = wfBaseName($this->file);
        if ($byteOrder === 'BE' || $byteOrder === 'LE') {
            $this->byteOrder = $byteOrder;
        } else {
            // Only give a warning for b/c, since originally we didn't
            // require this. The number of things affected by this is
            // rather small.
            wfWarn('Exif class did not have byte order specified. ' .
                'Some properties may be decoded incorrectly.');
            $this->byteOrder = 'BE'; // BE seems about twice as popular as LE in jpg's.
        }

        $this->debugFile(__FUNCTION__, true);
        if (function_exists('exif_read_data')) {
            AtEase::suppressWarnings();
            $data = exif_read_data($this->file, '', true);
            AtEase::restoreWarnings();
        } else {
            throw new MWException("Internal error: exif_read_data not present. " .
                "\$wgShowEXIF may be incorrectly set or not checked by an extension.");
        }
        /**
         * exif_read_data() will return false on invalid input, such as
         * when somebody uploads a file called something.jpeg
         * containing random gibberish.
         */
        $this->mRawExifData = $data ?: [];
        $this->makeFilteredData();
        $this->collapseData();
        $this->debugFile(__FUNCTION__, false);
    }

    /**
     * Make $this->mFilteredExifData
     */
    private function makeFilteredData()
    {
        $this->mFilteredExifData = [];

        foreach ($this->mRawExifData as $section => $data) {
            if (!array_key_exists($section, $this->mExifTags)) {
                $this->debug($section, __FUNCTION__, "'$section' is not a valid Exif section");
                continue;
            }

            foreach ($data as $tag => $value) {
                if (!array_key_exists($tag, $this->mExifTags[$section])) {
                    $this->debug($tag, __FUNCTION__, "'$tag' is not a valid tag in '$section'");
                    continue;
                }

                if ($this->validate($section, $tag, $value)) {
                    // This is ok, as the tags in the different sections do not conflict.
                    // except in computed and thumbnail section, which we don't use.
                    $this->mFilteredExifData[$tag] = $value;
                } else {
                    $this->debug($value, __FUNCTION__, "'$tag' contained invalid data");
                }
            }
        }
    }

    /**
     * Collapse some fields together.
     * This converts some fields from exif form, to a more friendly form.
     * For example GPS latitude to a single number.
     *
     * The rationale behind this is that we're storing data, not presenting to the user
     * For example a longitude is a single number describing how far away you are from
     * the prime meridian. Well it might be nice to split it up into minutes and seconds
     * for the user, it doesn't really make sense to split a single number into 4 parts
     * for storage. (degrees, minutes, second, direction vs single floating point number).
     *
     * Other things this might do (not really sure if they make sense or not):
     * Dates -> mediawiki date format.
     * convert values that can be in different units to be in one standardized unit.
     *
     * As an alternative approach, some of this could be done in the validate phase
     * if we make up our own types like Exif::DATE.
     */
    private function collapseData()
    {
        $this->exifGPStoNumber('GPSLatitude');
        $this->exifGPStoNumber('GPSDestLatitude');
        $this->exifGPStoNumber('GPSLongitude');
        $this->exifGPStoNumber('GPSDestLongitude');

        if (isset($this->mFilteredExifData['GPSAltitude'])) {
            // We know altitude data is a <num>/<denom> from the validation
            // functions ran earlier. But multiplying such a string by -1
            // doesn't work well, so convert.
            [$num, $denom] = explode('/', $this->mFilteredExifData['GPSAltitude'], 2);
            $this->mFilteredExifData['GPSAltitude'] = (int)$num / (int)$denom;

            if (isset($this->mFilteredExifData['GPSAltitudeRef'])) {
                switch ($this->mFilteredExifData['GPSAltitudeRef']) {
                    case "\0":
                        // Above sea level
                        break;
                    case "\1":
                        // Below sea level
                        $this->mFilteredExifData['GPSAltitude'] *= -1;
                        break;
                    default:
                        // Invalid
                        unset($this->mFilteredExifData['GPSAltitude']);
                        break;
                }
            }
        }
        unset($this->mFilteredExifData['GPSAltitudeRef']);

        $this->exifPropToOrd('FileSource');
        $this->exifPropToOrd('SceneType');

        $this->charCodeString('UserComment');
        $this->charCodeString('GPSProcessingMethod');
        $this->charCodeString('GPSAreaInformation');

        // ComponentsConfiguration should really be an array instead of a string...
        // This turns a string of binary numbers into an array of numbers.

        if (isset($this->mFilteredExifData['ComponentsConfiguration'])) {
            $val = $this->mFilteredExifData['ComponentsConfiguration'];
            $ccVals = [];

            $strLen = strlen($val);
            for ($i = 0; $i < $strLen; $i++) {
                $ccVals[$i] = ord(substr($val, $i, 1));
            }
            $ccVals['_type'] = 'ol'; // this is for formatting later.
            $this->mFilteredExifData['ComponentsConfiguration'] = $ccVals;
        }

        // GPSVersion(ID) is treated as the wrong type by php exif support.
        // Go through each byte turning it into a version string.
        // For example: "\x02\x02\x00\x00" -> "2.2.0.0"

        // Also change exif tag name from GPSVersion (what php exif thinks it is)
        // to GPSVersionID (what the exif standard thinks it is).

        if (isset($this->mFilteredExifData['GPSVersion'])) {
            $val = $this->mFilteredExifData['GPSVersion'];
            $newVal = '';

            $strLen = strlen($val);
            for ($i = 0; $i < $strLen; $i++) {
                if ($i !== 0) {
                    $newVal .= '.';
                }
                $newVal .= ord(substr($val, $i, 1));
            }

            if ($this->byteOrder === 'LE') {
                // Need to reverse the string
                $newVal2 = '';
                for ($i = strlen($newVal) - 1; $i >= 0; $i--) {
                    $newVal2 .= substr($newVal, $i, 1);
                }
                $this->mFilteredExifData['GPSVersionID'] = $newVal2;
            } else {
                $this->mFilteredExifData['GPSVersionID'] = $newVal;
            }
            unset($this->mFilteredExifData['GPSVersion']);
        }
    }

    /**
     * Do userComment tags and similar. See pg. 34 of exif standard.
     * basically first 8 bytes is charset, rest is value.
     * This has not been tested on any shift-JIS strings.
     * @param string $prop Prop name
     */
    private function charCodeString($prop)
    {
        if (isset($this->mFilteredExifData[$prop])) {
            if (strlen($this->mFilteredExifData[$prop]) <= 8) {
                // invalid. Must be at least 9 bytes long.

                $this->debug($this->mFilteredExifData[$prop], __FUNCTION__, false);
                unset($this->mFilteredExifData[$prop]);

                return;
            }
            $charCode = substr($this->mFilteredExifData[$prop], 0, 8);
            $val = substr($this->mFilteredExifData[$prop], 8);

            switch ($charCode) {
                case "JIS\x00\x00\x00\x00\x00":
                    $charset = "Shift-JIS";
                    break;
                case "UNICODE\x00":
                    $charset = "UTF-16" . $this->byteOrder;
                    break;
                default: // ascii or undefined.
                    $charset = "";
                    break;
            }
            if ($charset) {
                AtEase::suppressWarnings();
                $val = iconv($charset, 'UTF-8//IGNORE', $val);
                AtEase::restoreWarnings();
            } else {
                // if valid utf-8, assume that, otherwise assume windows-1252
                $valCopy = $val;
                UtfNormal\Validator::quickIsNFCVerify($valCopy); // validates $valCopy.
                if ($valCopy !== $val) {
                    AtEase::suppressWarnings();
                    $val = iconv('Windows-1252', 'UTF-8//IGNORE', $val);
                    AtEase::restoreWarnings();
                }
            }

            // trim and check to make sure not only whitespace.
            $val = trim($val);
            if (strlen($val) === 0) {
                // only whitespace.
                $this->debug($this->mFilteredExifData[$prop], __FUNCTION__, "$prop: Is only whitespace");
                unset($this->mFilteredExifData[$prop]);

                return;
            }

            // all's good.
            $this->mFilteredExifData[$prop] = $val;
        }
    }

    /**
     * Convert an Exif::UNDEFINED from a raw binary string
     * to its value. This is sometimes needed depending on
     * the type of UNDEFINED field
     * @param string $prop Name of property
     */
    private function exifPropToOrd($prop)
    {
        if (isset($this->mFilteredExifData[$prop])) {
            $this->mFilteredExifData[$prop] = ord($this->mFilteredExifData[$prop]);
        }
    }

    /**
     * Convert gps in exif form to a single floating point number
     * for example 10 degrees 20`40`` S -> -10.34444
     * @param string $prop A GPS coordinate exif tag name (like GPSLongitude)
     */
    private function exifGPStoNumber($prop)
    {
        $loc =& $this->mFilteredExifData[$prop];
        $dir =& $this->mFilteredExifData[$prop . 'Ref'];
        $res = false;

        if (isset($loc) && isset($dir)
            && ($dir === 'N' || $dir === 'S' || $dir === 'E' || $dir === 'W')
        ) {
            [$num, $denom] = explode('/', $loc[0], 2);
            $res = (int)$num / (int)$denom;
            [$num, $denom] = explode('/', $loc[1], 2);
            $res += ((int)$num / (int)$denom) * (1 / 60);
            [$num, $denom] = explode('/', $loc[2], 2);
            $res += ((int)$num / (int)$denom) * (1 / 3600);

            if ($dir === 'S' || $dir === 'W') {
                $res *= -1; // make negative
            }
        }

        // update the exif records.

        if ($res !== false) { // using !== as $res could potentially be 0
            $this->mFilteredExifData[$prop] = $res;
            unset($this->mFilteredExifData[$prop . 'Ref']);
        } else { // if invalid
            unset($this->mFilteredExifData[$prop]);
            unset($this->mFilteredExifData[$prop . 'Ref']);
        }
    }

    /** #@- */

    /** #@+
     * @return array
     */

    /**
     * Get $this->mRawExifData
     * @return array
     */
    public function getData()
    {
        return $this->mRawExifData;
    }

    /**
     * Get $this->mFilteredExifData
     * @return array
     */
    public function getFilteredData()
    {
        return $this->mFilteredExifData;
    }

    /** #@- */

    /**
     * The version of the output format
     *
     * Before the actual metadata information is saved in the database we
     * strip some of it since we don't want to save things like thumbnails
     * which usually accompany Exif data. This value gets saved in the
     * database along with the actual Exif data, and if the version in the
     * database doesn't equal the value returned by this function the Exif
     * data is regenerated.
     *
     * @return int
     */
    public static function version()
    {
        return 2; // We don't need no bloddy constants!
    }

    /**
     * Validates if a tag value is of the type it should be according to the Exif spec
     *
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isByte($in)
    {
        if (!is_array($in) && sprintf('%d', $in) == $in && $in >= 0 && $in <= 255) {
            $this->debug($in, __FUNCTION__, true);

            return true;
        } else {
            $this->debug($in, __FUNCTION__, false);

            return false;
        }
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isASCII($in)
    {
        if (is_array($in)) {
            return false;
        }

        if (preg_match("/[^\x0a\x20-\x7e]/", $in)) {
            $this->debug($in, __FUNCTION__, 'found a character that is not allowed');

            return false;
        }

        if (preg_match('/^\s*$/', $in)) {
            $this->debug($in, __FUNCTION__, 'input consisted solely of whitespace');

            return false;
        }

        return true;
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isShort($in)
    {
        if (!is_array($in) && sprintf('%d', $in) == $in && $in >= 0 && $in <= 65536) {
            $this->debug($in, __FUNCTION__, true);

            return true;
        } else {
            $this->debug($in, __FUNCTION__, false);

            return false;
        }
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isLong($in)
    {
        if (!is_array($in) && sprintf('%d', $in) == $in && $in >= 0 && $in <= 4294967296) {
            $this->debug($in, __FUNCTION__, true);

            return true;
        } else {
            $this->debug($in, __FUNCTION__, false);

            return false;
        }
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isRational($in)
    {
        $m = [];

        # Avoid division by zero
        if (!is_array($in)
            && preg_match('/^(\d+)\/(\d+[1-9]|[1-9]\d*)$/', $in, $m)
        ) {
            return $this->isLong($m[1]) && $this->isLong($m[2]);
        } else {
            $this->debug($in, __FUNCTION__, 'fed a non-fraction value');

            return false;
        }
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isUndefined($in)
    {
        $this->debug($in, __FUNCTION__, true);

        return true;
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isSlong($in)
    {
        if ($this->isLong(abs((float)$in))) {
            $this->debug($in, __FUNCTION__, true);

            return true;
        } else {
            $this->debug($in, __FUNCTION__, false);

            return false;
        }
    }

    /**
     * @param mixed $in The input value to check
     * @return bool
     */
    private function isSrational($in)
    {
        $m = [];

        # Avoid division by zero
        if (!is_array($in) &&
            preg_match('/^(-?\d+)\/(\d+[1-9]|[1-9]\d*)$/', $in, $m)
        ) {
            return $this->isSlong($m[0]) && $this->isSlong($m[1]);
        } else {
            $this->debug($in, __FUNCTION__, 'fed a non-fraction value');

            return false;
        }
    }

    /** #@- */

    /**
     * Validates if a tag has a legal value according to the Exif spec
     *
     * @param string $section Section where tag is located.
     * @param string $tag The tag to check.
     * @param mixed $val The value of the tag.
     * @param bool $recursive True if called recursively for array types.
     * @return bool
     */
    private function validate($section, $tag, $val, $recursive = false)
    {
        $debug = "tag is '$tag'";
        $etype = $this->mExifTags[$section][$tag];
        $ecount = 1;
        if (is_array($etype)) {
            [$etype, $ecount] = $etype;
            if ($recursive) {
                $ecount = 1; // checking individual elements
            }
        }

        $count = 1;
        if (is_array($val)) {
            $count = count($val);
            if ($ecount != $count) {
                $this->debug($val, __FUNCTION__, "Expected $ecount elements for $tag but got $count");

                return false;
            }
        }
        // If there are multiple values, recursively validate each of them.
        if ($count > 1) {
            foreach ($val as $v) {
                if (!$this->validate($section, $tag, $v, true)) {
                    return false;
                }
            }

            return true;
        }
        // Does not work if not typecast
        switch ((string)$etype) {
            case (string)self::BYTE:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isByte($val);
            case (string)self::ASCII:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isASCII($val);
            case (string)self::SHORT:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isShort($val);
            case (string)self::LONG:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isLong($val);
            case (string)self::RATIONAL:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isRational($val);
            case (string)self::SHORT_OR_LONG:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isShort($val) || $this->isLong($val);
            case (string)self::UNDEFINED:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isUndefined($val);
            case (string)self::SLONG:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isSlong($val);
            case (string)self::SRATIONAL:
                $this->debug($val, __FUNCTION__, $debug);

                return $this->isSrational($val);
            case (string)self::IGNORE:
                $this->debug($val, __FUNCTION__, $debug);

                return false;
            default:
                $this->debug($val, __FUNCTION__, "The tag '$tag' is unknown");

                return false;
        }
    }

    /**
     * Convenience function for debugging output
     *
     * @param mixed $in Arrays will be processed with print_r().
     * @param string $fname Function name to log.
     * @param string|bool|null $action Default null.
     */
    private function debug($in, $fname, $action = null)
    {
        if (!$this->log) {
            return;
        }
        $type = gettype($in);
        $class = ucfirst(__CLASS__);
        if (is_array($in)) {
            $in = print_r($in, true);
        }

        if ($action === true) {
            wfDebugLog($this->log, "$class::$fname: accepted: '$in' (type: $type)");
        } elseif ($action === false) {
            wfDebugLog($this->log, "$class::$fname: rejected: '$in' (type: $type)");
        } elseif ($action === null) {
            wfDebugLog($this->log, "$class::$fname: input was: '$in' (type: $type)");
        } else {
            wfDebugLog($this->log, "$class::$fname: $action (type: $type; content: '$in')");
        }
    }

    /**
     * Convenience function for debugging output
     *
     * @param string $fname The name of the function calling this function
     * @param bool $io Specify whether we're beginning or ending
     */
    private function debugFile($fname, $io)
    {
        if (!$this->log) {
            return;
        }
        $class = ucfirst(__CLASS__);
        if ($io) {
            wfDebugLog($this->log, "$class::$fname: begin processing: '{$this->basename}'");
        } else {
            wfDebugLog($this->log, "$class::$fname: end processing: '{$this->basename}'");
        }
    }
}
