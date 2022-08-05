<?php

namespace MediaWiki\Search\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SearchableNamespaces" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SearchableNamespacesHook
{
    /**
     * Use this hook to modify which namespaces are searchable.
     *
     * @param int[] &$arr Array of namespaces ($nsId => $name) which will be used
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSearchableNamespaces(&$arr);
}
