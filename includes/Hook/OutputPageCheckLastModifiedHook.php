<?php

namespace MediaWiki\Hook;

use OutputPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "OutputPageCheckLastModified" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface OutputPageCheckLastModifiedHook
{
    /**
     * This hook is called when checking if the page has been modified
     * since the last visit.
     *
     * @param string[] &$modifiedTimes Array of timestamps.
     *   The following keys are set: page, user, epoch.
     * @param OutputPage $out since 1.28
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onOutputPageCheckLastModified(&$modifiedTimes, $out);
}
