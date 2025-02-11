<?php

namespace MediaWiki\Page\Hook;

use Article;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticleViewFooter" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticleViewFooterHook
{
    /**
     * This hook is called after showing the footer section of an ordinary page view.
     *
     * @param Article $article
     * @param bool $patrolFooterShown Whether patrol footer is shown
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticleViewFooter($article, $patrolFooterShown);
}
