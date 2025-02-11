<?php
/**
 * Backend for regular file upload.
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
 * @ingroup Upload
 */

/**
 * Implements regular file uploads
 *
 * @ingroup Upload
 * @author Bryan Tong Minh
 */
class UploadFromFile extends UploadBase
{
    /**
     * @var WebRequestUpload
     */
    protected $mUpload = null;

    /**
     * @param WebRequest &$request
     */
    public function initializeFromRequest(&$request)
    {
        $upload = $request->getUpload('wpUploadFile');
        $desiredDestName = $request->getText('wpDestFile');
        if (!$desiredDestName) {
            $desiredDestName = $upload->getName();
        }

        // @phan-suppress-next-line PhanTypeMismatchArgumentNullable getName only null on failure
        $this->initialize($desiredDestName, $upload);
    }

    /**
     * Initialize from a filename and a WebRequestUpload
     * @param string $name
     * @param WebRequestUpload $webRequestUpload
     */
    public function initialize($name, $webRequestUpload)
    {
        $this->mUpload = $webRequestUpload;
        $this->initializePathInfo($name,
            $this->mUpload->getTempName(), $this->mUpload->getSize());
    }

    /**
     * @param WebRequest $request
     * @return bool
     */
    public static function isValidRequest($request)
    {
        # Allow all requests, even if no file is present, so that an error
        # because a post_max_size or upload_max_filesize overflow
        return true;
    }

    /**
     * @return string
     */
    public function getSourceType()
    {
        return 'file';
    }

    /**
     * @return array
     */
    public function verifyUpload()
    {
        # Check for a post_max_size or upload_max_size overflow, so that a
        # proper error can be shown to the user
        if ($this->mTempPath === null || $this->isEmptyFile()) {
            if ($this->mUpload->isIniSizeOverflow()) {
                return [
                    'status' => UploadBase::FILE_TOO_LARGE,
                    'max'    => min(
                        self::getMaxUploadSize($this->getSourceType()),
                        self::getMaxPhpUploadSize()
                    ),
                ];
            }
        }

        return parent::verifyUpload();
    }
}
