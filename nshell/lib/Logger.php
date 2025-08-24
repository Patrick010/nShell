<?php

/**
 * nShell Logging
 *
 * @package nShell
 */

namespace OCA\nShell;

/**
 * Handles all logging for nShell.
 */
class Logger
{
    /**
     * The path to the log file.
     * @var string
     */
    private string $logFile;

    /**
     * Logger constructor.
     *
     * @param string $logFile The path to the log file.
     */
    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    /**
     * Writes a message to the log file.
     *
     * @param string $message The message to log.
     * @return void
     */
    public function log(string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] " . $message . PHP_EOL;
        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
