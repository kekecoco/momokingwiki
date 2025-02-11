<?php

namespace MediaWiki\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetLocalURL::Article" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetLocalURL__ArticleHook
{
    /**
     * Use this hook to modify local URLs specifically pointing to article paths
     * without any fancy queries or variants.
     *
     * @param Title $title Title object of page
     * @param string &$url String value as output (out parameter, can modify)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetLocalURL__Article($title, &$url);
}
