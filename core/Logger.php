<?php

namespace core;

class Logger
{
    public static function log($message)
    {
        $date = date('Y-m-d H:i:s');
        $logContent = "$date : $message" . PHP_EOL;
        self::saveLog($logContent);
    }

    public static function logException($e)
    {
        $date = date('Y-m-d H:i:s');
        $logContent = "$date : " . $e->getMessage() . PHP_EOL;
        $logContent .= $e->getTraceAsString() . PHP_EOL;
        self::saveLog($logContent);
    }

    public static function clearLog()
    {
        $logPath = self::getLogPath();
        file_put_contents($logPath, '');
    }

    private static function getLogPath()
    {
        $logPath = APP_ROOT . '/log/app.log';
        if (!file_exists($logPath)) {
            // create the log file recursively
            $logDir = dirname($logPath);
            if (!file_exists($logDir)) {
                mkdir($logDir, 0777, true);
            }
            touch($logPath);
        }
        return $logPath;
    }

    private static function saveLog($logContent)
    {
        $logPath = self::getLogPath();
        file_put_contents($logPath, $logContent, FILE_APPEND);
    }
}