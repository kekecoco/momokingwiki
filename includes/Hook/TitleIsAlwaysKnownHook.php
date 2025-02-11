<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "TitleIsAlwaysKnown" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface TitleIsAlwaysKnownHook
{
    /**
     * This hook is called when determining if a page exists. Use this hook to
     * override default behavior for determining if a page exists. If $isKnown is
     * kept as null, regular checks happen. If it's a boolean, this value is returned
     * by the isKnown method.
     *
     * @param Title $title Title object that is being checked
     * @param bool|null &$isKnown Whether MediaWiki currently thinks this page is known
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onTitleIsAlwaysKnown($title, &$isKnown);
}
