<?php

namespace MediaWiki\Hook;

use MediaWiki\Revision\RevisionRecord;
use stdClass;
use XmlDumpWriter;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "XmlDumpWriterWriteRevision" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface XmlDumpWriterWriteRevisionHook
{
    /**
     * This hook is called at the end of a revision in an XML dump, to add extra metadata.
     *
     * @param XmlDumpWriter $obj
     * @param string &$out Text being output
     * @param stdClass $row Database row for the revision being dumped. DEPRECATED, use $rev instead.
     * @param string $text Revision text to be dumped. DEPRECATED, use $rev instead.
     * @param RevisionRecord $rev RevisionRecord that is being dumped to XML
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onXmlDumpWriterWriteRevision($obj, &$out, $row, $text, $rev);
}
