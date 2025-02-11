<?php

namespace MediaWiki\Page\Hook;

use stdClass;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ArticlePageDataAfter" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ArticlePageDataAfterHook
{
    /**
     * This hook is called after loading data of an article from the database.
     *
     * @param WikiPage $wikiPage WikiPage whose data were loaded
     * @param stdClass &$row Row returned from the database server
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticlePageDataAfter($wikiPage, &$row);
}
