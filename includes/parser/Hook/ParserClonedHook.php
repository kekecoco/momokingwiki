<?php

namespace MediaWiki\Hook;

use Parser;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ParserCloned" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ParserClonedHook
{
    /**
     * This hook is called when the parser is cloned.
     *
     * @param Parser $parser Newly-cloned Parser object
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onParserCloned($parser);
}
