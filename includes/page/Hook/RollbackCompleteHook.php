<?php

namespace MediaWiki\Page\Hook;

use MediaWiki\Revision\RevisionRecord;
use MediaWiki\User\UserIdentity;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "RollbackComplete" to register handlers implementing this interface.
 *
 * @deprecated since 1.36, use PageSaveComplete
 * @ingroup Hooks
 */
interface RollbackCompleteHook
{
    /**
     * After an article rollback is completed.
     *
     * @param WikiPage $wikiPage the WikiPage that was edited
     * @param UserIdentity $user UserIdentity for the user who did the rollback
     * @param RevisionRecord $revision RevisionRecord for the revision the page was reverted back to
     * @param RevisionRecord $current RevisionRecord for the reverted revision
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onRollbackComplete($wikiPage, $user, $revision,
                                       $current
    );
}
