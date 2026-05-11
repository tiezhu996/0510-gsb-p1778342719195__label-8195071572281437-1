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

echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'N/A') . "\n";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'N/A') . "\n";

$request = \think\Request::instance();
echo "\npathinfo(): " . $request->pathinfo() . "\n";
echo "path(): " . $request->path() . "\n";
echo "param('id'): " . $request->param('id') . "\n";
echo "param('action'): " . $request->param('action') . "\n";
echo "all params: " . print_r($request->param(), true);
