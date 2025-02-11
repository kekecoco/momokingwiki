<?php

namespace MediaWiki\Hook;

use stdClass;
use Title;
use XmlDumpWriter;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "XmlDumpWriterOpenPage" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface XmlDumpWriterOpenPageHook
{
    /**
     * This hook is called at the end of XmlDumpWriter::openPage, to allow
     * extra metadata to be added.
     *
     * @param XmlDumpWriter $obj
     * @param string &$out Output string
     * @param stdClass $row Database row for the page
     * @param Title $title Title of the page
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onXmlDumpWriterOpenPage($obj, &$out, $row, $title);
}
