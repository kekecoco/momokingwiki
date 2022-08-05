<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SetupAfterCache" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SetupAfterCacheHook
{
    /**
     * This hook is called in Setup.php, after cache objects are set.
     *
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSetupAfterCache();
}
