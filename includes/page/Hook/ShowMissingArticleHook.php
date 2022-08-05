<?php

namespace MediaWiki\Page\Hook;

use Article;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ShowMissingArticle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ShowMissingArticleHook
{
    /**
     * This hook is called when generating the output for a non-existent page.
     *
     * @param Article $article Article corresponding to the page
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onShowMissingArticle($article);
}
