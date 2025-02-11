<?php

namespace MediaWiki\Hook;

use SpecialContributions;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "SpecialContributionsBeforeMainOutput" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface SpecialContributionsBeforeMainOutputHook
{
    /**
     * This hook is called before the form on Special:Contributions
     *
     * @param int $id User id number, only provided for backwards-compatibility
     * @param User $user User object representing user contributions are being fetched for
     * @param SpecialContributions $sp SpecialPage instance, providing context
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onSpecialContributionsBeforeMainOutput($id, $user, $sp);
}
