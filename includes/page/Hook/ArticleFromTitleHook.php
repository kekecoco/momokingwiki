<?php

namespace MediaWiki\Page\Hook;

use Article;
use IContextSource;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticleFromTitle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticleFromTitleHook
{
    /**
     * This hook is called when creating an article object from a title object using
     * Wiki::articleFromTitle().
     *
     * @param Title $title Title used to create the article object
     * @param Article &$article Article that will be returned
     * @param IContextSource $context
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticleFromTitle($title, &$article, $context);
}
