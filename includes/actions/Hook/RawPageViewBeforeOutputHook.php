<?php

namespace MediaWiki\Hook;

use RawAction;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "RawPageViewBeforeOutput" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface RawPageViewBeforeOutputHook
{
    /**
     * This hook is called right before the text is blown out in action=raw.
     *
     * @param RawAction $obj
     * @param string &$text The text that's going to be the output
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onRawPageViewBeforeOutput($obj, &$text);
}
