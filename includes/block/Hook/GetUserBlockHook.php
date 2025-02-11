<?php

namespace MediaWiki\Block\Hook;

use MediaWiki\Block\AbstractBlock;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GetUserBlock" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GetUserBlockHook
{
    /**
     * Use this hook to modify the block found by the block manager. This may be a
     * single block or a composite block made from multiple blocks; the original
     * blocks can be seen using CompositeBlock::getOriginalBlocks().
     *
     * @param User $user User targeted by the block
     * @param string|null $ip IP of the current request if $user is the current user
     *   and they're not exempted from IP blocks. Null otherwise.
     * @param AbstractBlock|null &$block User's block, or null if none was found
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGetUserBlock($user, $ip, &$block);
}
