<?php

namespace MediaWiki\Content\Hook;

use ContentHandler;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ContentHandlerForModelID" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ContentHandlerForModelIDHook
{
    /**
     * This hook is called when a ContentHandler is requested for a given content model name,
     * but no entry for that model exists in $wgContentHandlers. Note: if your extension implements
     * additional models via this hook, please use GetContentModels hook to make them known to core.
     *
     * @param string $modeName Requested content model name
     * @param ContentHandler &$handler Set this to a ContentHandler object, if desired
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onContentHandlerForModelID($modeName, &$handler);
}
