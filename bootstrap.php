<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', __DIR__ . '/');
}
if (!defined('CONTENT_PATH')) {
    define('CONTENT_PATH', 'content/');
}

error_reporting(E_ALL);

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
    $dotenv->load();
}
if (getenv('APP_ENV') == 'development') {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}
