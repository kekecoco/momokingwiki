<?php

namespace MediaWiki\Cache\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MessageCache::get" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MessageCache__getHook
{
    /**
     * This hook is called when fetching a message. Use this hook to override the key
     * for customisations. Given and returned message key must be formatted with:
     * 1) the first letter in lower case according to the content language
     * 2) spaces replaced with underscores
     *
     * @param string &$key Message key
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMessageCache__get(&$key);
}
