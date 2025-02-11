<?php

namespace MediaWiki\Storage\Hook;

use CommentStoreComment;
use MediaWiki\Revision\RenderedRevision;
use MediaWiki\User\UserIdentity;
use Status;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MultiContentSave" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MultiContentSaveHook
{
    /**
     * This hook is called before an article is saved.
     *
     * @param RenderedRevision $renderedRevision Planned revision.
     *   Provides access to: (1) ParserOutput of all slots,
     *   (2) RevisionRecord, which contains
     *     (2a) Title of the page that will be edited,
     *     (2b) RevisionSlots - content of all slots, including inherited slots,
     *     where content has already been modified by PreSaveTransform.
     *   NOTE: because this revision is not yet saved, slots don't have content ID
     *   or address, and revision itself doesn't have an ID.
     * @param UserIdentity $user Author of this new revision
     * @param CommentStoreComment $summary User-provided edit comment/summary
     *   (not an autosummary: will be empty if the user hasn't provided a comment)
     * @param int $flags Combination of EDIT_* flags, e.g. EDIT_MINOR
     * @param Status $status If the hook is aborted, error code can be placed into this Status
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMultiContentSave($renderedRevision, $user, $summary, $flags,
                                       $status
    );
}
