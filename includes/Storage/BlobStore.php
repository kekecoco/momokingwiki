<?php
/**
 * Service for loading and storing data blobs.
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

namespace MediaWiki\Storage;

use StatusValue;

/**
 * Service for loading and storing data blobs.
 *
 * @note This was written to act as a drop-in replacement for the corresponding
 *       static methods in the old Revision class (which was later removed in 1.37).
 *
 * @since 1.31
 */
interface BlobStore
{

    /**
     * Hint key for use with storeBlob, indicating the general role the block
     * takes in the application. For instance, it should be "page-content" if
     * the blob represents a Content object.
     */
    public const DESIGNATION_HINT = 'designation';

    /**
     * Hint key for use with storeBlob, indicating the page the blob is associated with.
     * This may be used for sharding.
     */
    public const PAGE_HINT = 'page_id';

    /**
     * Hint key for use with storeBlob, indicating the slot the blob is associated with.
     * May be relevant for reference counting.
     */
    public const ROLE_HINT = 'role_name';

    /**
     * Hint key for use with storeBlob, indicating the revision the blob is associated with.
     * This may be used for differential storage and reference counting.
     */
    public const REVISION_HINT = 'rev_id';

    /**
     * Hint key for use with storeBlob, indicating the parent revision of the revision
     * the blob is associated with. This may be used for differential storage.
     */
    public const PARENT_HINT = 'rev_parent_id';

    /**
     * Hint key for use with storeBlob, providing the SHA1 hash of the blob as passed to the
     * method. This can be used to avoid re-calculating the hash if it is needed by the BlobStore.
     */
    public const SHA1_HINT = 'cont_sha1';

    /**
     * Hint key for use with storeBlob, indicating the model of the content encoded in the
     * given blob. May be used to implement optimized storage for some well known models.
     */
    public const MODEL_HINT = 'cont_model';

    /**
     * Hint key for use with storeBlob, indicating the serialization format used to create
     * the blob, as a MIME type. May be used for optimized storage in the underlying database.
     */
    public const FORMAT_HINT = 'cont_format';

    /**
     * Hint key for an image name.
     */
    public const IMAGE_HINT = 'img_name';

    /**
     * Retrieve a blob, given an address.
     *
     * MCR migration note: this replaced Revision::loadText
     *
     * @param string $blobAddress The blob address as returned by storeBlob(),
     *        such as "tt:12345" or "ex:DB://s16/456/9876".
     * @param int $queryFlags See IDBAccessObject.
     *
     * @return string binary blob data
     * @throws BlobAccessException
     */
    public function getBlob($blobAddress, $queryFlags = 0);

    /**
     * A batched version of BlobStore::getBlob.
     *
     * @param string[] $blobAddresses An array of blob addresses.
     * @param int $queryFlags See IDBAccessObject.
     * @return StatusValue A status with a map of blobAddress => binary blob data or null
     *         if fetching the blob has failed. Fetch failures errors are the
     *         warnings in the status object.
     * @throws BlobAccessException
     * @since 1.34
     */
    public function getBlobBatch($blobAddresses, $queryFlags = 0);

    /**
     * Stores an arbitrary blob of data and returns an address that can be used with
     * getBlob() to retrieve the same blob of data,
     *
     * @param string $data raw binary data
     * @param array $hints An array of hints. Implementations may use the hints to optimize storage.
     * All hints are optional, supported hints depend on the implementation. Hint names by
     * convention correspond to the names of fields in the database. Callers are encouraged to
     * provide the well known hints as defined by the XXX_HINT constants.
     *
     * @return string an address that can be used with getBlob() to retrieve the data.
     * @throws BlobAccessException
     */
    public function storeBlob($data, $hints = []);

    /**
     * Check if the blob metadata or backing blob data store is read-only
     *
     * @return bool
     */
    public function isReadOnly();
}
