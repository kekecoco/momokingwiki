<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "TitleExists" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface TitleExistsHook
{
    /**
     * This hook is called when determining whether a page exists at a given title.
     *
     * @param Title $title Title being tested
     * @param bool &$exists Whether the title exists
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onTitleExists($title, &$exists);
}
