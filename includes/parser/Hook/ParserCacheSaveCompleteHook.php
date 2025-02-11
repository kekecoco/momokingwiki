<?php

namespace MediaWiki\Hook;

use ParserCache;
use ParserOptions;
use ParserOutput;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserCacheSaveComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserCacheSaveCompleteHook
{
    /**
     * This hook is called after a ParserOutput has been committed to
     * the parser cache.
     *
     * @param ParserCache $parserCache ParserCache object $parserOutput was stored in
     * @param ParserOutput $parserOutput ParserOutput object that was stored
     * @param Title $title Title of the page that was parsed to generate $parserOutput
     * @param ParserOptions $popts ParserOptions used for generating $parserOutput
     * @param int $revId ID of the revision that was parsed to create $parserOutput
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserCacheSaveComplete($parserCache, $parserOutput, $title,
                                              $popts, $revId
    );
}
