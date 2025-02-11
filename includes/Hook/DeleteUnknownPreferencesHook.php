<?php

namespace MediaWiki\Hook;

use Wikimedia\Rdbms\IDatabase;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DeleteUnknownPreferences" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DeleteUnknownPreferencesHook
{
    /**
     * This hook is called by the cleanupPreferences.php maintenance script
     * to build a WHERE clause with which to delete preferences that are not
     * known about. This hook is used by extensions that have dynamically-named
     * preferences that should not be deleted in the usual cleanup process.
     * For example, the Gadgets extension creates preferences prefixed with
     * 'gadget-', so anything with that prefix is excluded from the deletion.
     *
     * @param array &$where Array that will be passed as the $cond parameter to
     *   IDatabase::select() to determine what will be deleted from the user_properties
     *   table
     * @param IDatabase $db IDatabase object, useful for accessing $db->buildLike() etc.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onDeleteUnknownPreferences(&$where, $db);
}
