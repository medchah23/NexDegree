<?php
class Debugger
{
    public static function log($message)
    {
        $logFile = __DIR__ . '/debug.log';
        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[{$timestamp}] {$message}" . PHP_EOL;
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }

    public static function dump($variable, $label = 'Dump')
    {
        ob_start();
        var_dump($variable);
        $output = ob_get_clean();
        self::log("{$label}: {$output}");
    }

    public static function display($variable, $label = 'Debug')
    {
        echo "<pre><strong>{$label}:</strong> ";
        var_dump($variable);
        echo "</pre>";
    }
}
