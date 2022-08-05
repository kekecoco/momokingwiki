<?php

namespace MediaWiki\Hook;

use RefreshLinks;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MaintenanceRefreshLinksInit" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MaintenanceRefreshLinksInitHook
{
    /**
     * This hook is called before executing the refreshLinks.php maintenance script.
     *
     * @param RefreshLinks $refreshLinks
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMaintenanceRefreshLinksInit($refreshLinks);
}
