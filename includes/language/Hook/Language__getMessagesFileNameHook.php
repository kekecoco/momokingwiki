<?php

namespace MediaWiki\Languages\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "Language::getMessagesFileName" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface Language__getMessagesFileNameHook
{
    /**
     * Use this hook to change the path of a localisation file.
     *
     * @param string $code Language code or the language we're looking for a messages file for
     * @param string &$file Messages file path. You can override this to change the location.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLanguage__getMessagesFileName($code, &$file);
}
