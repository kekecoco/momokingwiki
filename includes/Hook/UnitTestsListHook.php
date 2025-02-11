<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UnitTestsList" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UnitTestsListHook
{
    /**
     * This hook is called when building a list of paths containing PHPUnit tests.
     * Since 1.24, paths pointing to a directory will be recursively scanned for
     * test case files matching the suffix "Test.php".
     *
     * @param array &$paths List of test cases and directories to search
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUnitTestsList(&$paths);
}
