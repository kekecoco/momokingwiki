<?php

namespace MediaWiki\Hook;

use Parser;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BeforeParserFetchFileAndTitle" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BeforeParserFetchFileAndTitleHook
{
    /**
     * This hook is called before an image is rendered by Parser.
     *
     * @param Parser $parser
     * @param Title $nt Image title
     * @param array &$options Array of options to RepoGroup::findFile. If it contains 'broken'
     *   as a key then the file will appear as a broken thumbnail.
     *   If it contains `private` as a key, the value must be an Authority object.
     * @param string &$descQuery Query string to add to thumbnail URL
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBeforeParserFetchFileAndTitle($parser, $nt, &$options,
                                                    &$descQuery
    );
}
