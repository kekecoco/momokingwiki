<?php

namespace MediaWiki\Hook;

use SpecialTrackingCategories;
use Title;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialTrackingCategories::generateCatLink" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialTrackingCategories__generateCatLinkHook
{
    /**
     * This hook is called for each category link on Special:TrackingCategories.
     *
     * @param SpecialTrackingCategories $specialPage
     * @param Title $catTitle The Title object of the linked category
     * @param string &$html The Result html
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialTrackingCategories__generateCatLink($specialPage,
                                                                 $catTitle, &$html
    );
}
