<?php

namespace MediaWiki\Hook;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "GalleryGetModes" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GalleryGetModesHook
{
    /**
     * Use this hook to get a list of classes that can render different modes of a gallery.
     *
     * @param array &$modeArray Associative array mapping mode names to classes that implement
     *   that mode. It is expected that all registered classes are a subclass of ImageGalleryBase.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onGalleryGetModes(&$modeArray);
}
