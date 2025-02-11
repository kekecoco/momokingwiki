<?php

namespace MediaWiki\Page\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "Article::MissingArticleConditions" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface Article__MissingArticleConditionsHook
{
    /**
     * This hook is called before fetching deletion and move log entries
     * to display a message of a non-existing page being deleted/moved.
     * Use this hook to hide unrelated log entries.
     *
     * @param array &$conds Array of query conditions (all of which have to be met;
     *   conditions will AND in the final query)
     * @param string[] $logTypes Array of log types being queried
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onArticle__MissingArticleConditions(&$conds, $logTypes);
}
