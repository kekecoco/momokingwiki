<?php

namespace MediaWiki\Hook;

use DeletedContribsPager;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "DeletedContribsPager::reallyDoQuery" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface DeletedContribsPager__reallyDoQueryHook
{
    /**
     * This hook is called before really executing the query for Special:DeletedContributions
     *
     * @param array &$data an array of results of all contribs queries
     * @param DeletedContribsPager $pager The DeletedContribsPager object hooked into
     * @param string $offset Index offset, inclusive
     * @param int $limit Exact query limit
     * @param bool $descending Query direction, false for ascending, true for descending
     * @return bool|void True or no return value to continue or false to abort
     * @see ContribsPager__reallyDoQueryHook
     *
     * @since 1.35
     *
     */
    public function onDeletedContribsPager__reallyDoQuery(&$data, $pager, $offset,
                                                          $limit, $descending
    );
}
