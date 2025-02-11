<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LocalisationCacheRecache" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LocalisationCacheRecacheHook
{
    /**
     * Called when loading the localisation data into
     * cache.
     *
     * @param ?mixed $cache The LocalisationCache object
     * @param ?mixed $code language code
     * @param ?mixed &$alldata The localisation data from core and extensions
     * @param ?mixed $unused Used to be $purgeBlobs, removed in 1.34
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLocalisationCacheRecache($cache, $code, &$alldata, $unused);
}
