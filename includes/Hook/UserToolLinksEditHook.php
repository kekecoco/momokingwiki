<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UserToolLinksEdit" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UserToolLinksEditHook
{
    /**
     * This hook is called when generating a list of user tool links, e.g.
     * "Foobar (Talk | Contribs | Block)".
     *
     * @param int $userId User ID of the current user
     * @param string $userText Username of the current user
     * @param string[] &$items Array of user tool links as HTML fragments
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUserToolLinksEdit($userId, $userText, &$items);
}
