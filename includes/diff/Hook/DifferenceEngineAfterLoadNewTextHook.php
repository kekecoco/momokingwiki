<?php

namespace MediaWiki\Diff\Hook;

use DifferenceEngine;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DifferenceEngineAfterLoadNewText" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DifferenceEngineAfterLoadNewTextHook
{
    /**
     * This hook is called in DifferenceEngine::loadNewText()
     * after the new revision's content has been loaded into the class member variable
     * $differenceEngine->mNewContent but before returning true from this function.
     *
     * @param DifferenceEngine $differenceEngine
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onDifferenceEngineAfterLoadNewText($differenceEngine);
}
