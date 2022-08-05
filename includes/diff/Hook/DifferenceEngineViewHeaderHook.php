<?php

namespace MediaWiki\Diff\Hook;

use DifferenceEngine;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineViewHeader" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineViewHeaderHook
{
    /**
     * This hook is called before diff display.
     *
     * @param DifferenceEngine $differenceEngine
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onDifferenceEngineViewHeader($differenceEngine);
}
