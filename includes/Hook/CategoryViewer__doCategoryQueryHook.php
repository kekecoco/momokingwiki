<?php

namespace MediaWiki\Hook;

use Wikimedia\Rdbms\IResultWrapper;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "CategoryViewer::doCategoryQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface CategoryViewer__doCategoryQueryHook
{
    /**
     * This hook is called after querying for pages to be displayed in a Category page.
     * Use this hook to batch load any related data about the pages.
     *
     * @param string $type Category type, either 'page', 'file', or 'subcat'
     * @param IResultWrapper $res Query result from Wikimedia\Rdbms\IDatabase::select()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onCategoryViewer__doCategoryQuery($type, $res);
}
