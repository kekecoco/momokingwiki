<?php

namespace MediaWiki\Hook;

use Title;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "AbortTalkPageEmailNotification" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface AbortTalkPageEmailNotificationHook
{
    /**
     * Use this hook to disable email notifications of edits to users' talk pages.
     *
     * @param User $targetUser User whom to send talk page email notification
     * @param Title $title Page title
     * @return bool|void True or no return value to continue, or false to cancel talk
     *   page email notification
     * @since 1.35
     *
     */
    public function onAbortTalkPageEmailNotification($targetUser, $title);
}
