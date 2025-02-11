<?php

namespace MediaWiki\Hook;

use Wikimedia\Rdbms\IMaintainableDatabase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "UnitTestsAfterDatabaseSetup" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface UnitTestsAfterDatabaseSetupHook
{
    /**
     * This hook is called right after MediaWiki's test
     * infrastructure has finished creating/duplicating core tables for unit tests.
     *
     * @param IMaintainableDatabase $database Database in question
     * @param string $prefix Table prefix to be used in unit tests
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onUnitTestsAfterDatabaseSetup($database, $prefix);
}
