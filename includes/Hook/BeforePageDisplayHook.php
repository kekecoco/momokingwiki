<?php

namespace MediaWiki\Hook;

use OutputPage;
use Skin;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BeforePageDisplay" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BeforePageDisplayHook
{
    /**
     * This hook is called prior to outputting a page.
     *
     * @param OutputPage $out
     * @param Skin $skin
     * @return void This hook must not abort, it must return no value
     * @since 1.35
     *
     */
    public function onBeforePageDisplay($out, $skin): void;
}
