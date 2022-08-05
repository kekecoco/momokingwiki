<?php

use PHPUnit\Framework\TestFailure;
use PHPUnit\TextUI\ResultPrinter;

class MediaWikiPHPUnitResultPrinter extends ResultPrinter
{

    /**
     * @param TestFailure $defect
     * @return void
     */
    protected function printDefectTrace(TestFailure $defect): void
    {
        parent::printDefectTrace($defect);
        $test = $defect->getTestName();
        $log = MediaWikiLoggerPHPUnitExtension::$testsCollection[$test] ?? null;
        if ($log) {
            $this->write("=== Logs generated by test case\n{$log}\n===\n");
        }
    }
}
