<?php

namespace MediaWiki\Content\Hook;

use Content;
use WikiPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PlaceNewSection" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PlaceNewSectionHook
{
    /**
     * Use this hook to override placement of new sections.
     *
     * @param WikiPage|Content $content Formerly a WikiPage, but accidentally a
     *   Content object since approximately 1.21
     * @param string $oldtext Text of the article before editing
     * @param string $subject Subject of the new section
     * @param string &$text Text of the new section
     * @return bool|void True or no return value to continue, or false and put the
     *   merged text into $text to override the default behavior
     * @since 1.35
     *
     */
    public function onPlaceNewSection($content, $oldtext, $subject, &$text);
}
