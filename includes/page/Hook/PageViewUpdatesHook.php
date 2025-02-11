<?php

namespace MediaWiki\Page\Hook;

use User;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PageViewUpdates" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PageViewUpdatesHook
{
    /**
     * Use this hook to make database (or other) changes after a
     * page view is seen by MediaWiki.  Note this does not capture views made
     * via external caches such as Squid.
     *
     * @param WikiPage $wikipage Page being viewed
     * @param User $user User who is viewing
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onPageViewUpdates($wikipage, $user);
}
