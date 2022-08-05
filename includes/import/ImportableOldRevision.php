<?php

use MediaWiki\Revision\SlotRecord;

/**
 * @since 1.31
 */
interface ImportableOldRevision
{

    /**
     * @return User|null Typically null, use {@see getUser} instead
     * @since 1.31
     * @deprecated since 1.39, use {@see getUser} instead; this is almost always null anyway
     */
    public function getUserObj();

    /**
     * @return string
     * @since 1.31
     */
    public function getUser();

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
     * @return string
     * @since 1.31
     */
    public function getComment();

    /**
     * @return string
     * @since 1.31
     */
    public function getModel();

    /**
     * @return string
     * @since 1.31
     */
    public function getFormat();

    /**
     * @param string $role
     * @return Content
     * @since 1.31
     */
    public function getContent($role = SlotRecord::MAIN);

    /**
     * @param string $role
     * @return SlotRecord
     * @since 1.35
     */
    public function getSlot($role);

    /**
     * @return string[]
     * @since 1.35
     */
    public function getSlotRoles();

    /**
     * @return bool
     * @since 1.31
     */
    public function getMinor();

    /**
     * @return bool|string
     * @since 1.31
     */
    public function getSha1Base36();

    /**
     * @return string[]
     * @since 1.34
     */
    public function getTags();

}
