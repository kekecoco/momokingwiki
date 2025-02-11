<?php

namespace MediaWiki\Search\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SearchResultInitFromTitle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SearchResultInitFromTitleHook
{
    /**
     * Use this hook to set the revision used when displaying a page in
     * search results.
     *
     * @param Title $title Current title being displayed in search results
     * @param int|bool &$id Revision ID (default is false, for latest)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSearchResultInitFromTitle($title, &$id);
}
