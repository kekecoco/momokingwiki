<?php

namespace MediaWiki\Page\Hook;

use Article;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticleShowPatrolFooter" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticleShowPatrolFooterHook
{
    /**
     * This hook is called at the beginning of Article#showPatrolFooter.
     * Use this hook to not show the [mark as patrolled] link in certain
     * circumstances.
     *
     * @param Article $article
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticleShowPatrolFooter($article);
}
