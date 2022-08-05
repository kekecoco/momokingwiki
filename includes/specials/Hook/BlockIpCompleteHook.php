<?php

namespace MediaWiki\Hook;

use MediaWiki\Block\DatabaseBlock;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BlockIpComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface BlockIpCompleteHook
{
    /**
     * This hook is called after an IP address or user is blocked.
     *
     * @param DatabaseBlock $block the block object that was saved
     * @param User $user the user who did the block (not the one being blocked)
     * @param ?DatabaseBlock $priorBlock the block object for the prior block, if there was one
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBlockIpComplete($block, $user, $priorBlock);
}
