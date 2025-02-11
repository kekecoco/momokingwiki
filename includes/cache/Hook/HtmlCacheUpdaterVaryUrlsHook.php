<?php

namespace MediaWiki\Cache\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "HtmlCacheUpdaterVaryUrls" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface HtmlCacheUpdaterVaryUrlsHook
{
    /**
     * This hook is used to add variants of URLs to purge from HTTP caches.
     *
     * Extensions that provide site-wide variants of all URLs, such as by serving from an
     * alternate domain or path, can use this hook to append alternative URLs for each url in
     * $urls.
     *
     * @param array $urls Canonical URLs
     * @param array &$append Append alternative URLs for $urls
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onHtmlCacheUpdaterVaryUrls($urls, &$append);
}
