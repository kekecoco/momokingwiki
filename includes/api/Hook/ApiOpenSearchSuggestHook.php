<?php

namespace MediaWiki\Api\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiOpenSearchSuggest" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiOpenSearchSuggestHook
{
    /**
     * This hook is called when constructing the OpenSearch results. Hooks
     * can alter or append to the array.
     *
     * @param array[] &$results Array with integer keys to associative arrays.
     *   Keys in associative array:
     *     - `title`: Title object
     *     - `redirect from`: Title or null
     *     - `extract`: Description for this result
     *     - `extract trimmed`: If truthy, the extract will not be trimmed to
     *       $wgOpenSearchDescriptionLength.
     *     - `image`: Thumbnail for this result. Value is an array with subkeys `source`
     *       (URL), `width`, `height`, `alt`, and `align`.
     *     - `url`: URL for the given title
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onApiOpenSearchSuggest(&$results);
}
