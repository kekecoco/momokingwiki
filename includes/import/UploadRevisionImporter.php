<?php

/**
 * @since 1.31
 */
interface UploadRevisionImporter
{

    /**
     * @param ImportableUploadRevision $importableUploadRevision
     *
     * @return StatusValue On success, the value member contains the
     *     archive name, or an empty string if it was a new file.
     * @since 1.31
     *
     */
    public function import(ImportableUploadRevision $importableUploadRevision);

}
