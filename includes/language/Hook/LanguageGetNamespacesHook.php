<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LanguageGetNamespaces" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LanguageGetNamespacesHook
{
    /**
     * Use this hook to provide custom ordering for namespaces or
     * remove namespaces. Do not use this hook to add namespaces. Use
     * CanonicalNamespaces for that.
     *
     * @param string[] &$namespaces Array of namespaces indexed by their numbers
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLanguageGetNamespaces(&$namespaces);
}
