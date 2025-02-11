<?php

namespace MediaWiki\Hook;

use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetFullURL" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetFullURLHook
{
    /**
     * Use this hook to modify fully-qualified URLs used in redirects/export/offsite data.
     *
     * @param Title $title Title object of page
     * @param string &$url String value as output (out parameter, can modify)
     * @param string $query Query options as string passed to Title::getFullURL()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetFullURL($title, &$url, $query);
}
