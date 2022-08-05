<?php

namespace MediaWiki\Hook;

use Article;

/**
 * @stable to implement
 * @ingroup Hooks
 */
interface ProtectionFormAddFormFieldsHook
{
    /**
     * This hook is called after all protection type form fields are added.
     *
     * @param Article $article Title being (un)protected
     * @param array &$hookFormOptions An array to add form fields to
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.36
     *
     */
    public function onProtectionFormAddFormFields($article, &$hookFormOptions);
}
