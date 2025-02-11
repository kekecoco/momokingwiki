<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "IsUploadAllowedFromUrl" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface IsUploadAllowedFromUrlHook
{
    /**
     * Use this hook to override the result of UploadFromUrl::isAllowedUrl().
     *
     * @param string $url URL used to upload from
     * @param bool &$allowed Whether uploading is allowed for given URL
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onIsUploadAllowedFromUrl($url, &$allowed);
}
