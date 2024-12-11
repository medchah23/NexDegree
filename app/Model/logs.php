<?php

class logs
{
    private $logFile;

    public function __construct($logFile = 'app.log')
    {
        $this->logFile = $logFile;
    }

    /**
     * Logs an informational message.
     *
     * @param string $message
     * @param array $context
     */
    public function info($message, $context = [])
    {
        $this->writeLog('INFO', $message, $context);
    }

    /**
     * Logs a warning message.
     *
     * @param string $message
     * @param array $context
     */
    public function warning($message, $context = [])
    {
        $this->writeLog('WARNING', $message, $context);
    }

    /**
     * Logs an error message.
     *
     * @param string $message
     * @param array $context
     */
    public function error($message, $context = [])
    {
        $this->writeLog('ERROR', $message, $context);
    }

    /**
     * Writes a log message to the log file.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     */
    private function writeLog($level, $message, $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $formattedContext = $this->formatContext($context);
        $logMessage = "[{$timestamp}] {$level}: {$message} {$formattedContext}\n";

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Formats the context array into a string.
     *
     * @param array $context
     * @return string
     */
    private function formatContext($context)
    {
        if (empty($context)) {
            return '';
        }

        return json_encode($context);
    }
}
