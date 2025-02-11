<?php

namespace MediaWiki\Cache\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "MessagesPreLoad" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface MessagesPreLoadHook
{
    /**
     * This hook is called when loading a message from the database.
     *
     * @param string $title Title of the message
     * @param string &$message Message you want to define
     * @param string $code Language code
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onMessagesPreLoad($title, &$message, $code);
}
