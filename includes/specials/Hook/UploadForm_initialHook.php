<?php

namespace MediaWiki\Hook;

use SpecialUpload;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UploadForm:initial" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UploadForm_initialHook
{
    /**
     * This hook is called before the upload form is generated.
     *
     * Extensions might set the member-variables $uploadFormTextTop and
     * $uploadFormTextAfterSummary to inject text (HTML) either before or after the editform.
     *
     * @param SpecialUpload $upload
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUploadForm_initial($upload);
}
