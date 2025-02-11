<?php

namespace MediaWiki\Hook;

use OutputPage;
use Skin;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SkinSubPageSubtitle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SkinSubPageSubtitleHook
{
    /**
     * This hook is called at the beginning of Skin::subPageSubtitle().
     *
     * @param string &$subpages Subpage links HTML
     * @param Skin $skin
     * @param OutputPage $out
     * @return bool|void True or no return value to continue or false to abort.
     *   If true is returned, $subpages will be ignored and the rest of subPageSubtitle()
     *   will run. If false is returned, $subpages will be used instead of the HTML
     *   subPageSubtitle() generates.
     * @since 1.35
     *
     */
    public function onSkinSubPageSubtitle(&$subpages, $skin, $out);
}
