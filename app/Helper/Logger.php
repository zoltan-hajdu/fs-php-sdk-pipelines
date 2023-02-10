<?php
//define logger class
namespace App\Helper;

use App\Configuration\Configuration;

class Logger
{
    protected static $fileName = __DIR__ . '../../../logger';

    public static function writeLog(string $event, string $data): void
    {
        if (Configuration::isEnableLogging()) {
            $file = '';
            $time = @date('[Y/m/d,H:i:s]');
            $message = 'Request: ' . $event . '; Data: ' . $data;
            if (false === file_exists(realpath(self::$fileName . '.log'))) {
                $file = self::createFile();
            } else {
                $file = self::openFile();
            }
            fwrite($file, $time . '; ' . $message . PHP_EOL . "\n");
        }
    }

    public static function createFile()
    {
        return fopen(self::$fileName . '.log', 'wb');
    }

    public static function removeFile(): void
    {
        unlink(self::$fileName . '.log');
    }

    private static function openFile()
    {
        return fopen(self::$fileName . '.log', 'ab');
    }
}
