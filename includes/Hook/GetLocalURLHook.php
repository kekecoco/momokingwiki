<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetLocalURL" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetLocalURLHook
{
    /**
     * Use this hook to modify local URLs as output into page links. Note that if you are
     * working with internal urls (non-interwiki) then it may be preferable to work
     * with the GetLocalURL::Internal or GetLocalURL::Article hooks as GetLocalURL can
     * be buggy for internal URLs on render if you do not re-implement the horrible
     * hack that Title::getLocalURL uses in your own extension.
     *
     * @param Title $title Title object of page
     * @param string &$url String value as output (out parameter, can modify)
     * @param string $query Query options as string passed to Title::getLocalURL()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetLocalURL($title, &$url, $query);
}
