<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LocalisationCacheRecacheFallback" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LocalisationCacheRecacheFallbackHook
{
    /**
     * Called for each language when merging
     * fallback data into the cache.
     *
     * @param ?mixed $cache The LocalisationCache object
     * @param ?mixed $code language code
     * @param ?mixed &$alldata The localisation data from core and extensions. Note some keys may
     *   be omitted if they won't be merged into the final result.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLocalisationCacheRecacheFallback($cache, $code, &$alldata);
}
