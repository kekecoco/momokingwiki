<?php

namespace MediaWiki\Content\Hook;

use ContentHandler;
use ParserOutput;
use SearchEngine;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SearchDataForIndex" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SearchDataForIndexHook
{
    /**
     * Use this hook to add data to search document. Allows you to add any data to
     * the field map used to index the document.
     *
     * @param array &$fields Array of name => value pairs for fields
     * @param ContentHandler $handler ContentHandler for the content being indexed
     * @param WikiPage $page WikiPage that is being indexed
     * @param ParserOutput $output ParserOutput that is produced from the page
     * @param SearchEngine $engine SearchEngine for which the indexing is intended
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSearchDataForIndex(&$fields, $handler, $page, $output,
                                         $engine
    );
}
