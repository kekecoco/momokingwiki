<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EditFormPreloadText" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EditFormPreloadTextHook
{
    /**
     * Use this hook to populate the edit form when creating pages.
     *
     * @param string &$text Text to preload with
     * @param Title $title Page being created
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onEditFormPreloadText(&$text, $title);
}
