<?php

namespace MediaWiki\Hook;

use EditPage;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "EditPageGetCheckboxesDefinition" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface EditPageGetCheckboxesDefinitionHook
{
    /**
     * Use this hook to modify the edit checkboxes and other form fields
     * below the textarea in the edit form.
     *
     * @param EditPage $editpage Current EditPage object
     * @param array &$checkboxes Array of checkbox definitions. See
     *   EditPage::getCheckboxesDefinition() for the format.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onEditPageGetCheckboxesDefinition($editpage, &$checkboxes);
}
