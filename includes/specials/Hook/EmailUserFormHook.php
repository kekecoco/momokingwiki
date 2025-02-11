<?php

namespace MediaWiki\Hook;

use HTMLForm;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EmailUserForm" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EmailUserFormHook
{
    /**
     * This hook is called after building the email user form object.
     *
     * @param HTMLForm &$form HTMLForm object
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onEmailUserForm(&$form);
}
