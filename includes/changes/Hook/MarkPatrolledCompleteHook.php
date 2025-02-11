<?php

namespace MediaWiki\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MarkPatrolledComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MarkPatrolledCompleteHook
{
    /**
     * This hook is called after an edit is marked patrolled.
     *
     * @param int $rcid ID of the revision marked as patrolled
     * @param User $user User who marked the edit patrolled
     * @param bool $wcOnlySysopsCanPatrol Config setting indicating whether the user must be a
     *   sysop to patrol the edit
     * @param bool $auto True if the edit is being marked as patrolled automatically
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMarkPatrolledComplete($rcid, $user, $wcOnlySysopsCanPatrol,
                                            $auto
    );
}
