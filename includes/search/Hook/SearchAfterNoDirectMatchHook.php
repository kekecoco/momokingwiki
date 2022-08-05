<?php

namespace MediaWiki\Search\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SearchAfterNoDirectMatch" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SearchAfterNoDirectMatchHook
{
    /**
     * This hook is called if there was no match for the exact result. This
     * runs before lettercase variants are attempted, whereas 'SearchGetNearMatch'
     * runs after.
     *
     * @param string $term Search term
     * @param Title &$title Outparam; set to $title object and return false for a match
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSearchAfterNoDirectMatch($term, &$title);
}
