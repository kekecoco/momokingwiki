<?php

namespace MediaWiki\Hook;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "WikiExporter::dumpStableQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface WikiExporter__dumpStableQueryHook
{
    /**
     * Use this hook to get the SELECT query for "stable" revisions
     * dumps. One, and only one hook should set this, and return false.
     *
     * @param array &$tables Database tables to use in the SELECT query
     * @param array &$opts Options to use for the query
     * @param array &$join Join conditions
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onWikiExporter__dumpStableQuery(&$tables, &$opts, &$join);
}
