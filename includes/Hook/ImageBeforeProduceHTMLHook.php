<?php

namespace MediaWiki\Hook;

use DummyLinker;
use File;
use Parser;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ImageBeforeProduceHTML" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ImageBeforeProduceHTMLHook
{
    /**
     * This hook is called before producing the HTML created by a wiki image insertion.
     * You can skip the default logic entirely by returning false, or just modify a few
     * things using call-by-reference.
     *
     * @param DummyLinker $linker Formerly a Skin/Linker, now a DummyLinker for b/c
     * @param Title &$title Title object of the image
     * @param File|false &$file File object, or false if it doesn't exist
     * @param array &$frameParams Various parameters with special meanings; see documentation in
     *   includes/Linker.php for Linker::makeImageLink
     * @param array &$handlerParams Various parameters with special meanings; see documentation in
     *   includes/Linker.php for Linker::makeImageLink
     * @param string|bool &$time Timestamp of file in 'YYYYMMDDHHIISS' string
     *   form, or false for current
     * @param string &$res Final HTML output, used if you return false
     * @param Parser $parser
     * @param string &$query Query params for desc URL
     * @param string &$widthOption Used by the parser to remember the user preference thumbnailsize
     * @return bool|void True or no return value to continue or false to skip the default logic
     * @since 1.35
     *
     */
    public function onImageBeforeProduceHTML($linker, &$title, &$file,
                                             &$frameParams, &$handlerParams, &$time, &$res, $parser, &$query, &$widthOption
    );
}
