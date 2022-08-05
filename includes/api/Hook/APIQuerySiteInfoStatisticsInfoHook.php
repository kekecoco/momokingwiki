<?php

namespace MediaWiki\Api\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "APIQuerySiteInfoStatisticsInfo" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface APIQuerySiteInfoStatisticsInfoHook
{
    /**
     * Use this hook to add extra information to the site's statistics information.
     *
     * @param array &$results Array of results, add things here
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAPIQuerySiteInfoStatisticsInfo(&$results);
}
