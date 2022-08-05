<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ImportHandleUnknownUser" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ImportHandleUnknownUserHook
{
    /**
     * When a user doesn't exist locally, use this hook to auto-create it.
     *
     * @param string $name Username
     * @return bool|void True or no return value to continue. If the auto-creation is successful,
     *   return false.
     * @since 1.35
     *
     */
    public function onImportHandleUnknownUser($name);
}
