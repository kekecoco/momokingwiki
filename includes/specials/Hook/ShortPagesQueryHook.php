<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ShortPagesQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ShortPagesQueryHook
{
    /**
     * Use this hook to modify the query used by Special:ShortPages.
     *
     * @param array &$tables tables to join in the query
     * @param array &$conds conditions for the query
     * @param array &$joinConds join conditions for the query
     * @param array &$options options for the query
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onShortPagesQuery(&$tables, &$conds, &$joinConds, &$options);
}
