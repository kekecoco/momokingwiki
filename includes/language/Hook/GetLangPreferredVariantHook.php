<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetLangPreferredVariant" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetLangPreferredVariantHook
{
    /**
     * This hook is called in LanguageConverter#getPreferredVariant() to
     * allow fetching the language variant code from cookies or other such
     * alternative storage.
     *
     * @param string|null &$req Language variant from the URL or null if no variant
     *   was specified in the URL; the value of this variable comes from
     *   LanguageConverter#getURLVariant()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetLangPreferredVariant(&$req);
}
