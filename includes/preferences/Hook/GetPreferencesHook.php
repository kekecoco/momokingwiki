<?php

namespace MediaWiki\Preferences\Hook;

use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetPreferences" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetPreferencesHook
{
    /**
     * Use this hook to modify user preferences.
     *
     * @param User $user User whose preferences are being modified
     * @param array &$preferences Preferences description array, to be fed to an HTMLForm object
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetPreferences($user, &$preferences);
}
