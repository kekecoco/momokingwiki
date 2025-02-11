<?php

namespace MediaWiki\Hook;

use SpecialContributions;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialContributions::getForm::filters" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialContributions__getForm__filtersHook
{
    /**
     * This hook is called with a list of filters to render on Special:Contributions.
     *
     * @param SpecialContributions $sp SpecialContributions object, for context
     * @param array &$filters List of filter object definitions (compatible with OOUI form)
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialContributions__getForm__filters($sp, &$filters);
}
