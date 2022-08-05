<?php

namespace MediaWiki\Content\Hook;

use Content;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "ConvertContent" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface ConvertContentHook
{
    /**
     * This hook is called by AbstractContent::convert when a conversion to another content model
     * is requested. Handler functions that modify $result should generally return false to disable
     * further attempts at conversion.
     *
     * @param Content $content Content object to be converted
     * @param string $toModel ID of the content model to convert to
     * @param bool $lossy Whether lossy conversion is allowed
     * @param Content|bool &$result Output parameter, in case the handler function wants to
     *   provide a converted Content object. Note that $result->getContentModel() must return
     *   $toModel.
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onConvertContent($content, $toModel, $lossy, &$result);
}
