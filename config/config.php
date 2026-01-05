<?php

// Am Anfang hinzufügen
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


define('DB_HOST', '********');
define('DB_NAME', '********');
define('DB_USER', '********');
define('DB_PASS', '********');
define('BASE_URL', '/');

define('VIEWS_PATH', dirname(__DIR__) . '/app/views');
define('CACHE_PATH', __DIR__ . '/../cache');

// Twig Debug Mode
define('TWIG_DEBUG', false);