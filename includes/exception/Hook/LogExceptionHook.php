<?php

namespace MediaWiki\Hook;

use ErrorException;
use Exception;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "LogException" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface LogExceptionHook
{
    /**
     * This hook is called before an exception (or PHP error) is logged. This is
     * meant for integration with external error aggregation services; returning false
     * will NOT prevent logging.
     *
     * @param Exception|ErrorException $e Exception (in case of a plain old PHP error,
     *   a wrapping ErrorException)
     * @param bool $suppressed True if the error was suppressed via
     *   error_reporting()/wfSuppressWarnings()
     * @return bool|void True or no return value to continue or false to abort
     * @since 1.35
     *
     */
    public function onLogException($e, $suppressed);
}
