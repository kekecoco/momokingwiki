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
 * @ingroup Watchlist
 */

use MediaWiki\Linker\LinkTarget;
use MediaWiki\Page\PageIdentity;
use MediaWiki\User\UserIdentity;
use Wikimedia\Rdbms\DBUnexpectedError;

/**
 * @author Addshore
 * @since 1.31 interface created. WatchedItemStore implementation available since 1.27
 */
interface WatchedItemStoreInterface
{

    /**
     * @since 1.31
     */
    public const SORT_ASC = 'ASC';

    /**
     * @since 1.31
     */
    public const SORT_DESC = 'DESC';

    /**
     * Count the number of individual items that are watched by the user.
     * If a subject and corresponding talk page are watched this will return 2.
     *
     * @param UserIdentity $user
     *
     * @return int
     * @since 1.31
     *
     */
    public function countWatchedItems(UserIdentity $user);

    /**
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return int
     * @since 1.31
     *
     */
    public function countWatchers($target);

    /**
     * Number of page watchers who also visited a "recent" edit
     *
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     * @param mixed $threshold timestamp accepted by wfTimestamp
     *
     * @return int
     * @throws DBUnexpectedError
     * @throws MWException
     * @since 1.31
     *
     */
    public function countVisitingWatchers($target, $threshold);

    /**
     * @param LinkTarget[]|PageIdentity[] $targets deprecated passing LinkTarget[] since 1.36
     * @param array $options Allowed keys:
     *        'minimumWatchers' => int
     *
     * @return array multi dimensional like $return[$namespaceId][$titleString] = int $watchers
     *         All targets will be present in the result. 0 either means no watchers or the number
     *         of watchers was below the minimumWatchers option if passed.
     * @since 1.31
     *
     */
    public function countWatchersMultiple(array $targets, array $options = []);

    /**
     * Number of watchers of each page who have visited recent edits to that page
     *
     * @param array $targetsWithVisitThresholds array of pairs (LinkTarget|PageIdentity $target,
     *     mixed $threshold),
     *        $threshold is:
     *        - a timestamp of the recent edit if $target exists (format accepted by wfTimestamp)
     *        - null if $target doesn't exist
     *      deprecated passing LinkTarget since 1.36
     * @param int|null $minimumWatchers
     *
     * @return array multi-dimensional like $return[$namespaceId][$titleString] = $watchers,
     *         where $watchers is an int:
     *         - if the page exists, number of users watching who have visited the page recently
     *         - if the page doesn't exist, number of users that have the page on their watchlist
     *         - 0 means there are no visiting watchers or their number is below the
     *     minimumWatchers
     *         option (if passed).
     * @since 1.31
     *
     */
    public function countVisitingWatchersMultiple(
        array $targetsWithVisitThresholds,
        $minimumWatchers = null
    );

    /**
     * Get an item (may be cached)
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return WatchedItem|false
     * @since 1.31
     *
     */
    public function getWatchedItem(UserIdentity $user, $target);

    /**
     * Loads an item from the db
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return WatchedItem|false
     * @since 1.31
     *
     */
    public function loadWatchedItem(UserIdentity $user, $target);

    /**
     * Loads a set of WatchedItems from the db.
     *
     * @param UserIdentity $user
     * @param LinkTarget[]|PageIdentity[] $targets deprecated passing LinkTarget[] since 1.36
     *
     * @return WatchedItem[]|false
     * @since 1.36
     *
     */
    public function loadWatchedItemsBatch(UserIdentity $user, array $targets);

    /**
     * @param UserIdentity $user
     * @param array $options Allowed keys:
     *        'forWrite' => bool defaults to false
     *        'sort' => string optional sorting by namespace ID and title
     *                     one of the self::SORT_* constants
     *        'sortByExpiry' => bool optional sorts by expiration date, with the titles
     *                     that will expire soonest at the top.
     *
     * @return WatchedItem[]
     * @since 1.35 Allows 'sortByExpiry' as a key in $options
     *
     * @since 1.31 Method Added
     */
    public function getWatchedItemsForUser(UserIdentity $user, array $options = []);

    /**
     * Must be called separately for Subject & Talk namespaces
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return bool
     * @since 1.31
     *
     */
    public function isWatched(UserIdentity $user, $target);

    /**
     * Whether the page is only being watched temporarily (has expiry).
     * Must be called separately for Subject & Talk namespaces.
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return bool
     * @since 1.35
     *
     */
    public function isTempWatched(UserIdentity $user, $target): bool;

    /**
     * @param UserIdentity $user
     * @param LinkTarget[]|PageIdentity[] $targets deprecated passing LinkTarget[] since 1.36
     *
     * @return array multi-dimensional like $return[$namespaceId][$titleString] = $timestamp,
     *         where $timestamp is:
     *         - string|null value of wl_notificationtimestamp,
     *         - false if $target is not watched by $user.
     * @since 1.31
     *
     */
    public function getNotificationTimestampsBatch(UserIdentity $user, array $targets);

    /**
     * Must be called separately for Subject & Talk namespaces
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     * @param string|null $expiry Optional expiry timestamp in any format acceptable to wfTimestamp().
     *   null will not create an expiry, or leave it unchanged should one already exist.
     * @since 1.35 Accepts $expiry parameter.
     *
     * @since 1.31 Method added.
     */
    public function addWatch(UserIdentity $user, $target, ?string $expiry = null);

    /**
     * @param UserIdentity $user
     * @param LinkTarget[]|PageIdentity[] $targets deprecated passing LinkTarget[] since 1.36
     * @param string|null $expiry Optional expiry timestamp in any format acceptable to wfTimestamp(),
     *   null will not create expiries, or leave them unchanged should they already exist.
     *
     * @return bool success
     * @since 1.31 Method added.
     * @since 1.35 Accepts $expiry parameter.
     *
     */
    public function addWatchBatchForUser(UserIdentity $user, array $targets, ?string $expiry = null);

    /**
     * Removes an entry for the UserIdentity watching the target (LinkTarget or PageIdentity)
     * Must be called separately for Subject & Talk namespaces
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     *
     * @return bool success
     * @throws DBUnexpectedError
     * @throws MWException
     * @since 1.31
     *
     */
    public function removeWatch(UserIdentity $user, $target);

    /**
     * @param UserIdentity $user The user to set the timestamps for
     * @param string|null $timestamp Set the update timestamp to this value
     * @param LinkTarget[]|PageIdentity[] $targets List of targets to update. Default to all targets.
     *        deprecated passing LinkTarget[] since 1.36
     *
     * @return bool success
     * @since 1.31
     *
     */
    public function setNotificationTimestampsForUser(
        UserIdentity $user,
        $timestamp,
        array $targets = []
    );

    /**
     * Reset all watchlist notification timestamps for a user using the job queue
     *
     * @param UserIdentity $user The user to reset the timestamps for
     * @param string|int|null $timestamp Value to set all timestamps to, null to clear them
     * @since 1.31
     *
     */
    public function resetAllNotificationTimestampsForUser(UserIdentity $user, $timestamp = null);

    /**
     * @param UserIdentity $editor The editor that triggered the update. Their notification
     *  timestamp will not be updated(they have already seen it)
     * @param LinkTarget|PageIdentity $target The target to update timestamps for
     *        deprecated passing LinkTarget since 1.36
     * @param string $timestamp Set the update (first unseen revision) timestamp to this value
     *
     * @return int[] Array of user IDs the timestamp has been updated for
     * @since 1.31
     *
     */
    public function updateNotificationTimestamp(
        UserIdentity $editor, $target, $timestamp);

    /**
     * Reset the notification timestamp of this entry
     *
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $title deprecated passing LinkTarget since 1.36
     * @param string $force Whether to force the write query to be executed even if the
     *    page is not watched or the notification timestamp is already NULL.
     *    'force' in order to force
     * @param int $oldid The revision id being viewed. If not given or 0, latest revision is
     *     assumed.
     *
     * @return bool success Whether a job was enqueued
     * @since 1.31
     *
     */
    public function resetNotificationTimestamp(
        UserIdentity $user, $title, $force = '', $oldid = 0);

    /**
     * @param UserIdentity $user
     * @param int|null $unreadLimit
     *
     * @return int|bool The number of unread notifications
     *                  true if greater than or equal to $unreadLimit
     * @since 1.31
     *
     */
    public function countUnreadNotifications(UserIdentity $user, $unreadLimit = null);

    /**
     * Check if the given title already is watched by the user, and if so
     * add a watch for the new title.
     *
     * To be used for page renames and such.
     *
     * @param LinkTarget|PageIdentity $oldTarget deprecated passing LinkTarget since 1.36
     * @param LinkTarget|PageIdentity $newTarget deprecated passing LinkTarget since 1.36
     * @since 1.31
     *
     */
    public function duplicateAllAssociatedEntries($oldTarget, $newTarget);

    /**
     * Check if the given title already is watched by the user, and if so
     * add a watch for the new title.
     *
     * To be used for page renames and such.
     * This must be called separately for Subject and Talk pages
     *
     * @param LinkTarget|PageIdentity $oldTarget deprecated passing LinkTarget since 1.36
     * @param LinkTarget|PageIdentity $newTarget deprecated passing LinkTarget since 1.36
     * @since 1.31
     *
     */
    public function duplicateEntry($oldTarget, $newTarget);

    /**
     * Synchronously clear the users watchlist.
     *
     * @param UserIdentity $user
     * @since 1.31
     *
     */
    public function clearUserWatchedItems(UserIdentity $user);

    /**
     * Does the size of the users watchlist require clearUserWatchedItemsUsingJobQueue() to be used
     * instead of clearUserWatchedItems()
     *
     * @param UserIdentity $user
     * @return bool
     * @since 1.35
     *
     */
    public function mustClearWatchedItemsUsingJobQueue(UserIdentity $user): bool;

    /**
     * Queues a job that will clear the users watchlist using the Job Queue.
     *
     * @param UserIdentity $user
     * @since 1.31
     *
     */
    public function clearUserWatchedItemsUsingJobQueue(UserIdentity $user);

    /**
     * Probabilistically add a job to purge the expired watchlist items, if watchlist
     * expiration is enabled, based on the value of $wgWatchlistPurgeRate
     *
     * @since 1.36
     */
    public function maybeEnqueueWatchlistExpiryJob(): void;

    /**
     * @param UserIdentity $user
     * @param LinkTarget[]|PageIdentity[] $targets deprecated passing LinkTarget[] since 1.36
     *
     * @return bool success
     * @since 1.32
     *
     */
    public function removeWatchBatchForUser(UserIdentity $user, array $targets);

    /**
     * Convert $timestamp to TS_MW or return null if the page was visited since then by $user
     *
     * Use this only on single-user methods (having higher read-after-write expectations)
     * and not in places involving arbitrary batches of different users
     *
     * Usage of this method should be limited to WatchedItem* classes
     *
     * @param string|null $timestamp Value of wl_notificationtimestamp from the DB
     * @param UserIdentity $user
     * @param LinkTarget|PageIdentity $target deprecated passing LinkTarget since 1.36
     * @return string|null TS_MW timestamp of first unseen revision or null if there isn't one
     */
    public function getLatestNotificationTimestamp(
        $timestamp, UserIdentity $user, $target);

    /**
     * Get the number of watchlist items that expire before the current time.
     *
     * @return int
     * @since 1.35
     *
     */
    public function countExpired(): int;

    /**
     * Remove some number of expired watchlist items.
     *
     * @param int $limit The number of items to remove.
     * @param bool $deleteOrphans Whether to also delete `watchlist_expiry` rows that have no
     * related `watchlist` rows (because not all code knows about the expiry table yet). This runs
     * two extra queries, so is only done from the purgeExpiredWatchlistItems.php maintenance script.
     * @since 1.35
     *
     */
    public function removeExpired(int $limit, bool $deleteOrphans = false): void;
}
