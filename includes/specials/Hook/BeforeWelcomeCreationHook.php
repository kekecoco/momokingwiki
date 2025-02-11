<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BeforeWelcomeCreation" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BeforeWelcomeCreationHook
{
    /**
     * This hook is called before the welcomecreation message is displayed to a newly created user.
     *
     * @param string &$welcome_creation_msg MediaWiki message name to display on the welcome screen
     *   to a newly created user account.
     * @param string &$injected_html Any HTML to inject after the "logged in" message of a newly
     *   created user account
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBeforeWelcomeCreation(
        &$welcome_creation_msg,
        &$injected_html
    );
}
