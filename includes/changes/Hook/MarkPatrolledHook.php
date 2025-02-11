<?php

namespace MediaWiki\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MarkPatrolled" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MarkPatrolledHook
{
    /**
     * This hook is called before an edit is marked patrolled.
     *
     * @param int $rcid ID of the revision to be marked patrolled
     * @param User $user User marking the revision as patrolled
     * @param bool $wcOnlySysopsCanPatrol Config setting indicating whether the user needs to be a
     *   sysop in order to mark an edit patrolled
     * @param bool $auto True if the edit is being marked as patrolled automatically
     * @param string[] &$tags Tags to be applied to the patrol log entry
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMarkPatrolled($rcid, $user, $wcOnlySysopsCanPatrol, $auto,
                                    &$tags
    );
}
