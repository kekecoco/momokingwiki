<?php

namespace MediaWiki\Cache\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BacklinkCacheGetPrefix" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BacklinkCacheGetPrefixHook
{
    /**
     * Use this hook to set a prefix for a specific link table.
     *
     * @param string $table Table name
     * @param string &$prefix
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBacklinkCacheGetPrefix($table, &$prefix);
}
