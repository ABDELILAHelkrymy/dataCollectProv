<?php

namespace Core;

class Dotenv
{
    public static function load()
    {
        // check if the .env file exists
        if (!file_exists(APP_ROOT . '/.env')) {
            return;
        }
        $dotenv = file_get_contents(APP_ROOT . '/.env');
        $lines = explode("\n", $dotenv);

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
            }
        }
    }
}