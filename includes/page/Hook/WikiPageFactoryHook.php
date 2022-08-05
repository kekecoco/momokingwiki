<?php

namespace MediaWiki\Page\Hook;

use Title;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "WikiPageFactory" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface WikiPageFactoryHook
{
    /**
     * Use this hook to override WikiPage class used for a title.
     *
     * @param Title $title Title of the page
     * @param WikiPage|null &$page Variable to set the created WikiPage to
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onWikiPageFactory($title, &$page);
}
