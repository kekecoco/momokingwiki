<?php

namespace MediaWiki\Page\Hook;

use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticlePurge" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticlePurgeHook
{
    /**
     * This hook is called before executing "&action=purge".
     *
     * @param WikiPage $wikiPage WikiPage to purge
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticlePurge($wikiPage);
}
