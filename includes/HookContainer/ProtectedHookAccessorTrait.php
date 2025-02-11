<?php

namespace MediaWiki\HookContainer;

use MediaWiki\MediaWikiServices;

/**
 * This trait provides an implementation of getHookContainer() and
 * getHookRunner() for classes that do not use dependency injection. Its
 * purpose is to provide a consistent API which can easily be maintained
 * after the class has been migrated to dependency injection.
 */
trait ProtectedHookAccessorTrait
{
    /**
     * Get a HookContainer, for running extension hooks or for hook metadata.
     *
     * @return HookContainer
     * @since 1.35
     */
    protected function getHookContainer()
    {
        return MediaWikiServices::getInstance()->getHookContainer();
    }

    /**
     * Get a HookRunner for running core hooks.
     *
     * @return HookRunner
     * @since 1.35
     * @internal This is for use by core only. Hook interfaces may be removed
     *   without notice.
     */
    protected function getHookRunner()
    {
        return new HookRunner($this->getHookContainer());
    }
}
