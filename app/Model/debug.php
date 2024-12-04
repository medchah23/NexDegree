<?php
class Debuggerr {
    private static $logFile = __DIR__ . '/debug.log';

    public static function log($message, $data = null) {
        $timestamp = date("Y-m-d H:i:s");
        $formattedMessage = "[$timestamp] $message";

        if ($data !== null) {
            $formattedMessage .= ": " . print_r($data, true);
        }

        file_put_contents(self::$logFile, $formattedMessage . PHP_EOL, FILE_APPEND);
    }

    public static function clearLog() {
        file_put_contents(self::$logFile, ""); // Clear log file
    }

    public static function getLogFilePath() {
        return self::$logFile;
    }
}
?>
