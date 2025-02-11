<?php

namespace MediaWiki\Hook;

use OutputPage;
use SpecialSearch;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialSearchResultsAppend" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialSearchResultsAppendHook
{
    /**
     * This hook is called immediately before returning HTML on the search results page.
     *
     * Useful for including a feedback link.
     *
     * @param SpecialSearch $specialSearch SpecialSearch object ($this)
     * @param OutputPage $output $wgOut
     * @param string $term Search term specified by the user
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialSearchResultsAppend($specialSearch, $output, $term);
}
