<?php

namespace MediaWiki\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PageRenderingHash" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PageRenderingHashHook
{
    /**
     * NOTE: Consider using ParserOptionsRegister instead.
     * Use this hook to alter the parser cache option hash key. A parser extension
     * which depends on user options should install this hook and append its values to
     * the key.
     *
     * @param string &$confstr Reference to a hash key string which can be modified
     * @param User $user User requesting the page
     * @param array &$forOptions Array of options the hash is for
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onPageRenderingHash(&$confstr, $user, &$forOptions);
}
