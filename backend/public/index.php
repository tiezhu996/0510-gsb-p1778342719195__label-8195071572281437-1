<?php
define('APP_PATH', __DIR__ . '/../application/');
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
define('APP_DEBUG', true);

require __DIR__ . '/../thinkphp/helpers.php';

\think\Config::init();

$request = \think\Request::instance();
$path = $request->pathinfo();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoginPage = strpos($path, '/auth/login') !== false || strpos($path, 'auth/login') !== false;
$isLoggedIn = isset($_SESSION['admin_id']);

if (!$isLoginPage && !$isLoggedIn) {
    header('Location: /admin/auth/login');
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$parts = explode('/', trim($path, '/'));
$module = isset($parts[0]) && $parts[0] ? $parts[0] : 'admin';
$rawController = isset($parts[1]) && $parts[1] ? $parts[1] : 'console';
$action = isset($parts[2]) && $parts[2] ? $parts[2] : 'index';
$id = isset($parts[3]) && $parts[3] ? $parts[3] : 0;

$controller = str_replace('_', '', ucwords($rawController, '_'));

$controllerClass = '\\app\\' . $module . '\\controller\\' . ucfirst($controller);

if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass($request);
    if (method_exists($controllerInstance, $action)) {
        $result = $controllerInstance->$action($id);
        if ($result) {
            echo $result;
        }
    }
}
