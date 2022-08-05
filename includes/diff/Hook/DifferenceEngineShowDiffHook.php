<?php

namespace MediaWiki\Diff\Hook;

use DifferenceEngine;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineShowDiff" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineShowDiffHook
{
    /**
     * Use this hook to affect the diff text which eventually gets sent to the OutputPage object.
     *
     * @param DifferenceEngine $differenceEngine
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onDifferenceEngineShowDiff($differenceEngine);
}
