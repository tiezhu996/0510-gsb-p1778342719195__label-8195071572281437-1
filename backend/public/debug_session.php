<?php
define('APP_PATH', __DIR__ . '/../application/');
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
define('APP_DEBUG', true);
require __DIR__ . '/../thinkphp/helpers.php';

\think\Config::init();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: text/plain');

echo "Session ID: " . session_id() . "\n";
echo "Session Status: " . session_status() . "\n";
echo "Session Save Path: " . session_save_path() . "\n";
echo "Cookie: " . ($_COOKIE['PHPSESSID'] ?? 'NOT SET') . "\n";
echo "Session Data:\n";
print_r($_SESSION);
echo "\nRequest Path: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "Admin ID in Session: " . ($_SESSION['admin_id'] ?? 'NOT SET') . "\n";
