<?php

namespace MediaWiki\Page\Hook;

use Article;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BeforeDisplayNoArticleText" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BeforeDisplayNoArticleTextHook
{
    /**
     * This hook is called before displaying message key "noarticletext" or
     * "noarticletext-nopermission" at Article::showMissingArticle().
     *
     * @param Article $article
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBeforeDisplayNoArticleText($article);
}
