<?php

namespace Wikimedia\Http;

/**
 * @internal
 * @since 1.35
 */
class SetCookieCompat
{
    /**
     * Temporary emulation for setcookie() with a SameSite option and encoding
     * spaces in values as "%20" rather than "+".
     *
     * Prior to PHP 7.4.3, setcookie() encoded spaces in cookie values as plus
     * signs. PHP 7.4.2 and later no longer decode plus signs as spaces, which
     * is a backward incompatible change that poses a problem when upgrading a
     * live site, especially if not all servers are to be upgraded at once.
     *
     * Once MediaWiki requires PHP 7.4.3, this can be replaced with a setcookie()
     * call in the caller.
     *
     * @see https://phabricator.wikimedia.org/T291127
     * @see https://bugs.php.net/bug.php?id=79174
     * @param string $name The full cookie name
     * @param string $value The cookie value
     * @param array $options The options as passed to setcookie() in PHP 7.3+
     * @return bool
     */
    public static function setcookie($name, $value, $options = [])
    {
        return (new self)->setCookieInternal(true, $name, $value, $options);
    }

    /**
     * Temporary emulation for setrawcookie() with a SameSite option
     *
     * Once MediaWiki requires PHP 7.3, this can be replaced with a setrawcookie()
     * call in the caller.
     *
     * @param string $name The full cookie name
     * @param string $value The cookie value
     * @param array $options The options as passed to setrawcookie() in PHP 7.3+
     * @return bool
     */
    public static function setrawcookie($name, $value, $options = [])
    {
        return (new self)->setCookieInternal(false, $name, $value, $options);
    }

    /**
     * @param bool $urlEncode True for setcookie(), false for setrawcookie()
     * @param string $name The full cookie name
     * @param string $value The cookie value
     * @param array $options The options as passed to setcookie() in PHP 7.3+
     * @return bool
     * @internal
     */
    public function setCookieInternal($urlEncode, $name, $value, $options = [])
    {
        $supportsAssoc = version_compare(PHP_VERSION, '7.3.0', '>=');
        if ($supportsAssoc) {
            if ($urlEncode && version_compare(PHP_VERSION, '7.4.3', '>=')) {
                return setcookie($name, $value, $options);
            } elseif ($urlEncode) {
                return setrawcookie($name, rawurlencode($value), $options);
            } else {
                return setrawcookie($name, $value, $options);
            }
        }

        if (!isset($options['samesite']) || !strlen($options['samesite'])) {
            return setrawcookie(
                $name,
                $urlEncode ? rawurlencode($value) : $value,
                $options['expires'],
                $options['path'],
                $options['domain'],
                $options['secure'],
                $options['httponly']
            );
        }

        return self::setCookieEmulated($urlEncode, $name, $value, $options);
    }

    /**
     * Temporary emulation for setcookie() or setrawcookie() to match PHP 7.4.3
     *
     * This function corresponds to php_head_parse_cookie_options_array() and
     * php_setcookie() in the PHP source code:
     *
     * https://github.com/php/php-src/blob/PHP-7.4.3/ext/standard/head.c#L189-L226
     * https://github.com/php/php-src/blob/PHP-7.4.3/ext/standard/head.c#L79-L187
     *
     * @param bool $urlEncode True for setcookie(), false for setrawcookie()
     * @param string $name The full cookie name
     * @param string|null $value The cookie value
     * @param array $options The options as passed to setcookie() in PHP 7.3+
     * @return bool
     * @internal
     */
    public function setCookieEmulated($urlEncode, $name, $value, $options = [])
    {
        $func = $urlEncode ? 'setcookie()' : 'setrawcookie()';
        $expires = 0;
        $path = null;
        $domain = null;
        $secure = false;
        $httponly = false;
        $samesite = null;
        $found = 0;
        foreach ($options as $key => $opt) {
            if ($key === 'expires') {
                $expires = (int)$opt;
                $found++;
            } elseif ($key === 'path') {
                $path = (string)$opt;
                $found++;
            } elseif ($key === 'domain') {
                $domain = (string)$opt;
                $found++;
            } elseif ($key === 'secure') {
                $secure = (bool)$opt;
                $found++;
            } elseif ($key === 'httponly') {
                $httponly = (bool)$opt;
                $found++;
            } elseif ($key === 'samesite') {
                $samesite = (string)$opt;
                $found++;
            } else {
                $this->error("$func: Unrecognized key '$key' found in the options array");
            }
        }

        if ($found == 0 && count($options) > 0) {
            $this->error("$func: No valid options were found in the given array");
        }

        if (!strlen($name)) {
            $this->error('Cookie names must not be empty');

            return false;
        } elseif (strpbrk($name, "=,; \t\r\n\013\014") !== false) {
            $this->error("Cookie names cannot contain any of the following " .
                "'=,; \\t\\r\\n\\013\\014'");

            return false;
        }

        if (!$urlEncode && $value !== null
            && strpbrk($value, ",; \t\r\n\013\014") !== false
        ) {
            $this->error("Cookie values cannot contain any of the following ',; \\t\\r\\n\\013\\014'");

            return false;
        }

        if ($path !== null && strpbrk($path, ",; \t\r\n\013\014") !== false) {
            $this->error("Cookie paths cannot contain any of the following ',; \\t\\r\\n\\013\\014'");

            return false;
        }

        if ($domain !== null && strpbrk($domain, ",; \t\r\n\013\014") !== false) {
            $this->error("Cookie domains cannot contain any of the following ',; \\t\\r\\n\\013\\014'");

            return false;
        }

        $buf = '';
        if ($value === null || strlen($value) === 0) {
            $dt = gmdate("D, d-M-Y H:i:s T", 1);
            $buf .= "Set-Cookie: $name=deleted; expires=$dt; Max-Age=0";
        } else {
            $buf .= "Set-Cookie: $name=";
            if ($urlEncode) {
                $buf .= rawurlencode($value);
            } else {
                $buf .= $value;
            }

            if ($expires > 0) {
                $dt = gmdate("D, d-M-Y H:i:s T", $expires);
                $p = strrpos($dt, '-');
                if ($p === false || substr($dt, $p + 5, 1) !== ' ') {
                    $this->error("Expiry date cannot have a year greater than 9999");

                    return false;
                }

                $buf .= "; expires=$dt";

                $diff = $expires - $this->time();
                if ($diff < 0) {
                    $diff = 0;
                }
                $buf .= "; Max-Age=$diff";
            }
        }

        if ($path !== null && strlen($path)) {
            $buf .= "; path=$path";
        }
        if ($domain !== null && strlen($domain)) {
            $buf .= "; domain=$domain";
        }
        if ($secure) {
            $buf .= "; secure";
        }
        if ($httponly) {
            $buf .= "; HttpOnly";
        }
        if ($samesite !== null && strlen($samesite)) {
            $buf .= "; SameSite=$samesite";
        }

        // sapi_header_op() returns a value which setcookie() uses, but
        // header() discards it. The most likely way for sapi_header_op() to
        // fail is due to headers already being sent.
        if ($this->headers_sent()) {
            $this->error("Cannot modify header information - headers already sent");

            return false;
        }
        $this->header($buf);

        return true;
    }

    protected function time()
    {
        return time();
    }

    protected function error($message)
    {
        trigger_error($message, E_USER_WARNING);
    }

    protected function headers_sent()
    {
        return headers_sent();
    }

    protected function header($header)
    {
        header($header, false);
    }
}
