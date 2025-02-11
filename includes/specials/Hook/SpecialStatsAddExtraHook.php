<?php

namespace MediaWiki\Hook;

use IContextSource;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialStatsAddExtra" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialStatsAddExtraHook
{
    /**
     * Use this hook to add extra statistics at the end of Special:Statistics.
     *
     * @param array &$extraStats Array to save the new stats
     *    $extraStats['<name of statistic>'] => <value>;
     *   <value> can be an array with the keys "name" and "number":
     *   "name" is the HTML to be displayed in the name column
     *   "number" is the number to be displayed.
     *   or, <value> can be the number to be displayed and <name> is the
     *   message key to use in the name column,
     * @param IContextSource $context
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialStatsAddExtra(&$extraStats, $context);
}
