<?php

namespace MediaWiki\Api\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ApiQueryTokensRegisterTypes" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ApiQueryTokensRegisterTypesHook
{
    /**
     * Use this hook to add additional token types to action=query&meta=tokens.
     * Note that most modules will probably be able to use the CSRF token
     * instead of creating their own token types.
     *
     * @param array &$salts [ type => salt to pass to User::getEditToken(), or array of salt
     *   and key to pass to Session::getToken() ]
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onApiQueryTokensRegisterTypes(&$salts);
}
