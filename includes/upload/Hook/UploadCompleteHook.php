<?php

namespace MediaWiki\Hook;

use UploadBase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UploadComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UploadCompleteHook
{
    /**
     * This hook is called upon completion of a file upload.
     *
     * @param UploadBase $uploadBase UploadBase (or subclass) object. File can be accessed by
     *   $uploadBase->getLocalFile().
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUploadComplete($uploadBase);
}
