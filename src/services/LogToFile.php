<?php
/**
 * LogToFile wrapper by Webburo Spring
 * For compatibility with both Craft 3 with putyourlightson/logtofile and Craft 4 with Monolog
 * Based on https://putyourlightson.com/articles/adding-logging-to-craft-plugins-with-monolog
 */

namespace lenvanessen\commerce\invoices\services;

use Craft;
use craft\log\MonologTarget;

use Monolog\Formatter\LineFormatter;

use putyourlightson\logtofile\LogToFile as LegacyLogToFile;

class LogToFile {

    private static $_logTargets = [];

    public static function log(string $message, string $handle, string $level = 'info') {

        if (!$handle)
            return;

        if (class_exists(LegacyLogToFile::class)) {
            // Craft 3.x only (putyourlightson/logtofile is not compatible with Craft 4)

            LegacyLogToFile::log($message, $handle, $level);
            return;
        }

        if (class_exists(MonologTarget::class) && class_exists(LineFormatter::class)) {
            // Craft 4.x

            if (!isset(self::$_logTargets[$handle])) {
                self::$_logTargets[$handle] = new MonologTarget([
                    'name' => $handle,
                    'categories' => $handle,
                    'level' => 'info',
                    'logContext' => false,
                    'allowLineBreaks' => false,
                    'formatter' => new LineFormatter(
                        format: "%datetime% %message%\n",
                        dateFormat: 'Y-m-d H:i:s',
                    ),
                ]);
                Craft::getLogger()->dispatcher->targets[] = self::$_logTargets[$handle];
            }

            Craft::getLogger()->log($message, $level, $handle);
            return;
        }
    }
}