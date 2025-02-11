<?php

namespace MediaWiki\Diff\Hook;

use DifferenceEngine;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineMarkPatrolledLink" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineMarkPatrolledLinkHook
{
    /**
     * Use this hook to change the "mark as patrolled" link which is shown both
     * on the diff header as well as on the bottom of a page, usually wrapped in
     * a span element which has class="patrollink".
     *
     * @param DifferenceEngine $differenceEngine
     * @param string &$markAsPatrolledLink "Mark as patrolled" link HTML
     * @param int $rcid Recent change ID (rc_id) for this change
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onDifferenceEngineMarkPatrolledLink($differenceEngine,
                                                        &$markAsPatrolledLink, $rcid
    );
}
