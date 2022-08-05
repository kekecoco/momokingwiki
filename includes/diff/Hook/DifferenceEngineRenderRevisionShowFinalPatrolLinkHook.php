<?php

namespace MediaWiki\Diff\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineRenderRevisionShowFinalPatrolLink" to register
 * handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineRenderRevisionShowFinalPatrolLinkHook
{
    /**
     * Use this hook to not show the final "mark as patrolled" link on the bottom of a page.
     * This hook has no arguments.
     *
     * @return bool|void True or no return value to continue, or false to not show the final
     *   "mark as patrolled" link
     * @since 1.35
     *
     */
    public function onDifferenceEngineRenderRevisionShowFinalPatrolLink();
}
