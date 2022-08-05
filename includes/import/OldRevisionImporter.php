<?php

/**
 * @since 1.31
 */
interface OldRevisionImporter
{

    /**
     * @param ImportableOldRevision $importableRevision
     *
     * @return bool Success
     * @since 1.31
     *
     */
    public function import(ImportableOldRevision $importableRevision);

}
