<?php

namespace MediaWiki\Hook;

use Parser;
use Title;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "BeforeParserFetchTemplateAndtitle" to register handlers implementing this interface.
 *
 * @deprecated since 1.36; use BeforeParserFetchTemplateRevisionRecordHook
 * @ingroup Hooks
 */
interface BeforeParserFetchTemplateAndtitleHook
{
    /**
     * This hook is called before a template is fetched by Parser.
     *
     * @param Parser $parser
     * @param Title $title Title of the template
     * @param bool &$skip Skip this template and link it?
     * @param int &$id ID of the revision being parsed
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onBeforeParserFetchTemplateAndtitle($parser, $title, &$skip,
                                                        &$id
    );
}
