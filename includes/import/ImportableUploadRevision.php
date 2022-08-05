<?php

/**
 * @since 1.31
 */
interface ImportableUploadRevision
{

    /**
     * @return string Archive name of a revision if archived.
     * @since 1.31
     */
    public function getArchiveName();

    /**
     * @return Title
     * @since 1.31
     */
    public function getTitle();

    /**
     * @return string
     * @since 1.31
     */
    public function getTimestamp();

    /**
     * @return string|null HTTP source of revision to be used for downloading.
     * @since 1.31
     */
    public function getSrc();

    /**
     * @return string Local file source of the revision.
     * @since 1.31
     */
    public function getFileSrc();

    /**
     * @return bool Is the return of getFileSrc only temporary?
     * @since 1.31
     */
    public function isTempSrc();

    /**
     * @return string|bool sha1 of the revision, false if not set or errors occur.
     * @since 1.31
     */
    public function getSha1();

    /**
     * @return User|null Typically null, use {@see getUser} instead
     * @since 1.31
     * @deprecated since 1.39, use {@see getUser} instead; this is almost always null anyway
     */
    public function getUserObj();

    /**
     * @return string The username of the user that created this revision
     * @since 1.31
     */
    public function getUser();

    /**
     * @return string
     * @since 1.31
     */
    public function getComment();

}
