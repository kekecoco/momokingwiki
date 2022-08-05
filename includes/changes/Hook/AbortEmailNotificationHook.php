<?php

namespace MediaWiki\Hook;

use RecentChange;
use Title;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "AbortEmailNotification" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface AbortEmailNotificationHook
{
    /**
     * Use this hook to cancel email notifications for an edit.
     *
     * @param User $editor User who made the change
     * @param Title $title Title of the page that was edited
     * @param RecentChange $rc Current RecentChange object
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAbortEmailNotification($editor, $title, $rc);
}
