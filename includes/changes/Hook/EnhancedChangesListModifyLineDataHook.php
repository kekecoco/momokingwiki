<?php

namespace MediaWiki\Hook;

use EnhancedChangesList;
use RecentChange;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EnhancedChangesListModifyLineData" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EnhancedChangesListModifyLineDataHook
{
    /**
     * Use this hook to alter data used to build a grouped recent change inner line in
     * EnhancedChangesList.
     *
     * @param EnhancedChangesList $changesList
     * @param array &$data Array of components that will be joined in order to create the line
     * @param RecentChange[] $block Array of RecentChange objects in that block
     * @param RecentChange $rc RecentChange object for this line
     * @param string[] &$classes Array of classes to change
     * @param string[] &$attribs Associative array of other HTML attributes for the `<tr>` element.
     *   Currently only data attributes reserved to MediaWiki are allowed
     *   (see Sanitizer::isReservedDataAttribute).
     * @return bool|void True or no return value to continue, or false to omit this line from
     *   recentchanges
     * @since 1.35
     *
     */
    public function onEnhancedChangesListModifyLineData($changesList, &$data,
                                                        $block, $rc, &$classes, &$attribs
    );
}
