<?php

namespace MediaWiki\Hook;

use Skin;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SkinPreloadExistence" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SkinPreloadExistenceHook
{
    /**
     * Use this hook to supply titles that should be added to link existence
     * cache before the page is rendered.
     *
     * @param Title[] &$titles
     * @param Skin $skin
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSkinPreloadExistence(&$titles, $skin);
}
