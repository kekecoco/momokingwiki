<?php

namespace MediaWiki\Search\Hook;

use ResultAugmentor;
use ResultSetAugmentor;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SearchResultsAugment" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SearchResultsAugmentHook
{
    /**
     * Use this hook to add code to the list of search result augmentors.
     *
     * @param ResultSetAugmentor[] &$setAugmentors List of whole-set augmentor objects,
     *   must implement ResultSetAugmentor
     * @param ResultAugmentor[] &$rowAugmentors List of per-row augmentor objects,
     *   must implement ResultAugmentor. Note that lists should be in the format
     *   name => object and the names in both lists should be distinct.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSearchResultsAugment(&$setAugmentors, &$rowAugmentors);
}
