<?php

namespace MediaWiki\Cache\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BacklinkCacheGetConditions" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BacklinkCacheGetConditionsHook
{
    /**
     * Use this hook to set conditions for query when links to certain title are fetched.
     *
     * @param string $table Table name
     * @param Title $title Title of the page to which backlinks are sought
     * @param array &$conds Query conditions
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBacklinkCacheGetConditions($table, $title, &$conds);
}
