<?php

namespace MediaWiki\Hook;

use ManualLogEntry;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ManualLogEntryBeforePublish" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ManualLogEntryBeforePublishHook
{
    /**
     * Use this hook to access or modify log entry just before it is
     * published.
     *
     * @param ManualLogEntry $logEntry
     * @return void This hook must not abort, it must return no value
     * @since 1.35
     *
     */
    public function onManualLogEntryBeforePublish($logEntry): void;
}
