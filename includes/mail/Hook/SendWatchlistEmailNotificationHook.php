<?php

namespace MediaWiki\Hook;

use EmailNotification;
use Title;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SendWatchlistEmailNotification" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SendWatchlistEmailNotificationHook
{
    /**
     * Use this hook to cancel watchlist email notifications (enotifwatchlist) for an edit.
     *
     * @param User $targetUser User whom to send watchlist email notification
     * @param Title $title Page title
     * @param EmailNotification $enotif
     * @return bool|void True or no return value to send watchlist email
     *   notification, or false to abort
     * @since 1.35
     *
     */
    public function onSendWatchlistEmailNotification($targetUser, $title, $enotif);
}
