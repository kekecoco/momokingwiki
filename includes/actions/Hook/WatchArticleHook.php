<?php

namespace MediaWiki\Hook;

use Status;
use User;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "WatchArticle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface WatchArticleHook
{
    /**
     * This hook is called before a watch is added to an article.
     *
     * @param User $user User that will watch
     * @param WikiPage $page WikiPage object to be watched
     * @param Status &$status Status object to be returned if the hook returns false
     * @param string|null $expiry Optional expiry timestamp in any format acceptable to wfTimestamp()
     * @return bool|void True or no return value to continue or false to abort and
     *   return Status object
     * @since 1.35
     *
     */
    public function onWatchArticle($user, $page, &$status, $expiry);
}
