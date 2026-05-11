<?php
define('APP_PATH', __DIR__ . '/../application/');
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
define('APP_DEBUG', true);
require __DIR__ . '/../thinkphp/helpers.php';

\think\Config::init();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$request = \think\Request::instance();
$path = $request->pathinfo();

$parts = explode('/', trim($path, '/'));
$module = isset($parts[0]) && $parts[0] ? $parts[0] : 'admin';
$rawController = isset($parts[1]) && $parts[1] ? $parts[1] : 'console';
$action = isset($parts[2]) && $parts[2] ? $parts[2] : 'index';
$id = isset($parts[3]) && $parts[3] ? $parts[3] : 0;

header('Content-Type: text/plain');

echo "Path: $path\n";
echo "Parts: " . print_r($parts, true);
echo "Module: $module\n";
echo "Controller: $rawController\n";
echo "Action: $action\n";
echo "ID: $id\n";

// Get all request parameters
echo "\nRequest Params (GET): " . print_r($_GET, true);
echo "\nRequest Params (POST): " . print_r($_POST, true);
echo "\nRequest Param (id): " . $request->param('id') . "\n";
