<?php

namespace MediaWiki\Hook;

use MediaWiki\Deferred\LinksUpdate\LinksUpdate;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LinksUpdateComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LinksUpdateCompleteHook
{
    /**
     * This hook is called at the end of LinksUpdate::doUpdate() when updating,
     * including delete and insert, has completed for all link tables.
     *
     * @param LinksUpdate $linksUpdate
     * @param mixed $ticket Prior result of LBFactory::getEmptyTransactionTicket()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLinksUpdateComplete($linksUpdate, $ticket);
}
