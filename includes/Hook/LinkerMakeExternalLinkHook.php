<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LinkerMakeExternalLink" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LinkerMakeExternalLinkHook
{
    /**
     * This hook is called at the end of Linker::makeExternalLink() just before the return.
     *
     * @param string &$url Link URL
     * @param string &$text Link text
     * @param string &$link New link HTML (if returning false)
     * @param string[] &$attribs Attributes to be applied
     * @param string $linkType External link type
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs,
                                             $linkType
    );
}
