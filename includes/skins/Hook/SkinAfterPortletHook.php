<?php

namespace MediaWiki\Skins\Hook;

use Skin;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SkinAfterPortlet" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SkinAfterPortletHook
{
    /**
     * This hook is called when generating portlets.
     * It allows injecting custom HTML after the portlet.
     *
     * @param Skin $skin
     * @param string $portletName
     * @param string &$html
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSkinAfterPortlet($skin, $portletName, &$html);
}
