<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SkinCopyrightFooter" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SkinCopyrightFooterHook
{
    /**
     * Use this hook for site and per-namespace customization of the copyright notice.
     *
     * @param Title $title Displayed page title
     * @param string $type Set to 'normal' or 'history' for old/diff views
     * @param string &$msg Overridable message, usually 'copyright' or 'history_copyright'.
     *   This message must be in HTML format, not wikitext!
     * @param string &$link Overridable HTML link to be passed into the message as $1
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSkinCopyrightFooter($title, $type, &$msg, &$link);
}
