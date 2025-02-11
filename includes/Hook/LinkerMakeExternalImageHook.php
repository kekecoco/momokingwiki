<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LinkerMakeExternalImage" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LinkerMakeExternalImageHook
{
    /**
     * This hook is called at the end of Linker::makeExternalImage() just before the return.
     *
     * @param string &$url Image URL
     * @param string &$alt Image's alt text
     * @param string &$img New image HTML (if returning false)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLinkerMakeExternalImage(&$url, &$alt, &$img);
}
