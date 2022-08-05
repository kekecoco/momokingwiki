<?php

namespace MediaWiki\Hook;

use Article;
use User;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "CustomEditor" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface CustomEditorHook
{
    /**
     * This hook is called when invoking the page editor.
     *
     * @param Article $article Article being edited
     * @param User $user User performing the edit
     * @return bool|void True or no return value to allow the normal editor to be used.
     *   False if implementing a custom editor, e.g. for a special namespace, etc.
     * @since 1.35
     *
     */
    public function onCustomEditor($article, $user);
}
