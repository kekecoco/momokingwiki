<?php

namespace MediaWiki\Api\Hook;

use ApiQuerySiteinfo;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "APIQuerySiteInfoGeneralInfo" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface APIQuerySiteInfoGeneralInfoHook
{
    /**
     * Use this hook to add extra information to the site's general information.
     *
     * @param ApiQuerySiteinfo $module Current ApiQuerySiteinfo module
     * @param array &$results Array of results, add things here
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onAPIQuerySiteInfoGeneralInfo($module, &$results);
}
