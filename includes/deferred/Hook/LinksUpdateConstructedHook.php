<?php

namespace MediaWiki\Hook;

use MediaWiki\Deferred\LinksUpdate\LinksUpdate;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LinksUpdateConstructed" to register handlers implementing this interface.
 *
 * @deprecated since 1.38 Use LinksUpdate or LinksUpdateComplete
 * @ingroup Hooks
 */
interface LinksUpdateConstructedHook
{
    /**
     * This hook is called at the end of LinksUpdate() is construction.
     *
     * @param LinksUpdate $linksUpdate
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLinksUpdateConstructed($linksUpdate);
}
