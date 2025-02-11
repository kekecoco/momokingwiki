<?php

namespace MediaWiki\Hook;

use SkinTemplate;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PersonalUrls" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PersonalUrlsHook
{
    /**
     * Use this hook to alter the user-specific navigation links (e.g. "my page,
     * my talk page, my contributions" etc).
     *
     * @param array &$personal_urls Array of link specifiers (see SkinTemplate.php)
     * @param Title &$title Current page
     * @param SkinTemplate $skin SkinTemplate object providing context (e.g. to check if the user is
     *   logged in, etc.)
     * @return void This hook must not abort, it must return no value
     * @since 1.35
     *
     */
    public function onPersonalUrls(&$personal_urls, &$title, $skin): void;
}
