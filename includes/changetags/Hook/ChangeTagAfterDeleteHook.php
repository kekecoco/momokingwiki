<?php

namespace MediaWiki\ChangeTags\Hook;

use Status;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ChangeTagAfterDelete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ChangeTagAfterDeleteHook
{
    /**
     * This hook is called after a change tag has been deleted (that is, removed from all
     * revisions and log entries to which it was applied). This gives extensions a chance
     * to take it off their books.
     *
     * @param string $tag Name of the tag
     * @param Status &$status Add warnings to this as required. There is no point setting errors,
     *   as the deletion has already been partly carried out by this point.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onChangeTagAfterDelete($tag, &$status);
}
