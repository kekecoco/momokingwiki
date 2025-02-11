<?php

namespace MediaWiki\Page\Hook;

use OutputPage;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticleDeleteAfterSuccess" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticleDeleteAfterSuccessHook
{
    /**
     * Use this hook to modify the output after an article has been deleted.
     *
     * @param Title $title Article that has been deleted
     * @param OutputPage $outputPage OutputPage that can be used to append the output
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticleDeleteAfterSuccess($title, $outputPage);
}
