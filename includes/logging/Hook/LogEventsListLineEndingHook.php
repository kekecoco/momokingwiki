<?php

namespace MediaWiki\Hook;

use DatabaseLogEntry;
use LogEventsList;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LogEventsListLineEnding" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LogEventsListLineEndingHook
{
    /**
     * This hook is called before a Special:Log line is finished.
     *
     * @param LogEventsList $page
     * @param string &$ret HTML line
     * @param DatabaseLogEntry $entry DatabaseLogEntry object for this row
     * @param string[] &$classes Classes to add to the surrounding `<li>`
     * @param array &$attribs Associative array of other HTML attributes for the `<li>` element.
     *   Currently only data attributes reserved to MediaWiki are allowed
     *   (see Sanitizer::isReservedDataAttribute).
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLogEventsListLineEnding($page, &$ret, $entry, &$classes,
                                              &$attribs
    );
}
