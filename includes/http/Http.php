<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

use MediaWiki\MainConfigNames;
use MediaWiki\MediaWikiServices;

/**
 * Various HTTP related functions
 * @deprecated since 1.34
 * @ingroup HTTP
 */
class Http
{
    /**
     * Perform an HTTP request
     *
     * @param string $method HTTP method. Usually GET/POST
     * @param string $url Full URL to act on. If protocol-relative, will be expanded to an http:// URL
     * @param array $options Options to pass to MWHttpRequest object. See HttpRequestFactory::create
     *  docs
     * @param string $caller The method making this request, for profiling
     * @return string|bool (bool)false on failure or a string on success
     * @deprecated since 1.34, use HttpRequestFactory::request()
     *
     */
    public static function request($method, $url, array $options = [], $caller = __METHOD__)
    {
        $ret = MediaWikiServices::getInstance()->getHttpRequestFactory()->request(
            $method, $url, $options, $caller);

        return is_string($ret) ? $ret : false;
    }

    /**
     * Simple wrapper for Http::request( 'GET' )
     *
     * @param string $url
     * @param array $options
     * @param string $caller The method making this request, for profiling
     * @return string|bool false on error
     * @deprecated since 1.34, use HttpRequestFactory::get()
     *
     * @since 1.25 Second parameter $timeout removed. Second parameter
     * is now $options which can be given a 'timeout'
     *
     */
    public static function get($url, array $options = [], $caller = __METHOD__)
    {
        $args = func_get_args();
        if (isset($args[1]) && (is_string($args[1]) || is_numeric($args[1]))) {
            // Second was used to be the timeout
            // And third parameter used to be $options
            wfWarn("Second parameter should not be a timeout.", 2);
            $options = isset($args[2]) && is_array($args[2]) ?
                $args[2] : [];
            $options['timeout'] = $args[1];
            $caller = __METHOD__;
        }

        return self::request('GET', $url, $options, $caller);
    }

    /**
     * Simple wrapper for Http::request( 'POST' )
     *
     * @param string $url
     * @param array $options
     * @param string $caller The method making this request, for profiling
     * @return string|bool false on error
     * @deprecated since 1.34, use HttpRequestFactory::post()
     *
     */
    public static function post($url, array $options = [], $caller = __METHOD__)
    {
        return self::request('POST', $url, $options, $caller);
    }

    /**
     * A standard user-agent we can use for external requests.
     *
     * @return string
     * @deprecated since 1.34, use HttpRequestFactory::getUserAgent()
     */
    public static function userAgent()
    {
        return MediaWikiServices::getInstance()->getHttpRequestFactory()->getUserAgent();
    }

    /**
     * Check that the given URI is a valid one.
     *
     * This hardcodes a small set of protocols only, because we want to
     * deterministically reject protocols not supported by all HTTP-transport
     * methods.
     *
     * "file://" specifically must not be allowed, for security purpose
     * (see <https://www.mediawiki.org/wiki/Special:Code/MediaWiki/r67684>).
     *
     * @param string $uri URI to check for validity
     * @return bool
     * @todo FIXME this is wildly inaccurate and fails to actually check most stuff
     *
     * @deprecated since 1.34, use MWHttpRequest::isValidURI
     */
    public static function isValidURI($uri)
    {
        return MWHttpRequest::isValidURI($uri);
    }

    /**
     * Gets the relevant proxy from $wgHTTPProxy
     *
     * @return string The proxy address or an empty string if not set.
     * @deprecated since 1.34, use $wgHTTPProxy directly
     */
    public static function getProxy()
    {
        wfDeprecated(__METHOD__, '1.34');

        $httpProxy = MediaWikiServices::getInstance()->getMainConfig()->get(
            MainConfigNames::HTTPProxy);

        return (string)$httpProxy;
    }

    /**
     * Get a configured MultiHttpClient
     *
     * @param array $options
     * @return MultiHttpClient
     * @deprecated since 1.34, use MediaWikiServices::getHttpRequestFactory()->createMultiClient()
     */
    public static function createMultiClient(array $options = [])
    {
        wfDeprecated(__METHOD__, '1.34');
        $httpProxy = MediaWikiServices::getInstance()->getMainConfig()->get(
            MainConfigNames::HTTPProxy);

        return MediaWikiServices::getInstance()->getHttpRequestFactory()
            ->createMultiClient($options + ['proxy' => $httpProxy]);
    }
}
