<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

require APP . 'config/config.php';
require APP . 'core/application.php';
require APP . 'core/controller.php';

// Ensure that a session exists
if( !session_id() )
{
    session_start();
}

$app = new Application();
