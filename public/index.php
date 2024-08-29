<?php

define('APP_ROOT', dirname(__DIR__));
include_once APP_ROOT . '/core/App.php';

use core\App;

$app = new App();

$app->run();
