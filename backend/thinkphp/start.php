<?php
define('THINK_PATH', __DIR__);
define('APP_PATH', dirname(__DIR__) . '/application/');
define('RUNTIME_PATH', dirname(__DIR__) . '/runtime/');

if (session_status() === PHP_SESSION_NONE) {
    $sessionId = $_COOKIE['PHPSESSID'] ?? null;
    if ($sessionId) {
        session_id($sessionId);
    }
    session_start();
}

require THINK_PATH . '/helpers.php';
require THINK_PATH . '/library/think/Loader.php';
require THINK_PATH . '/library/think/Config.php';
require THINK_PATH . '/library/think/Route.php';
require THINK_PATH . '/library/think/Controller.php';
require THINK_PATH . '/library/think/Model.php';
require THINK_PATH . '/library/think/View.php';
require THINK_PATH . '/library/think/Response.php';
require THINK_PATH . '/library/think/Db.php';
require THINK_PATH . '/library/think/Url.php';

define('APP_NAME', 'app');

\think\Loader::register();
\think\Config::init();

$request = \think\Request::instance();
$request->pathinfo();

$dispatch = $request->dispatch();
if (empty($dispatch)) {
    $dispatch = ['type' => 'module', 'module' => ['admin', 'console', 'index']];
}

$module = isset($dispatch['module'][0]) ? $dispatch['module'][0] : 'admin';
$controller = isset($dispatch['module'][1]) ? $dispatch['module'][1] : 'console';
$action = isset($dispatch['module'][2]) ? $dispatch['module'][2] : 'index';

$controllerClass = '\\app\\' . $module . '\\controller\\' . ucfirst($controller);

if (!class_exists($controllerClass)) {
    echo "Controller not found: $controllerClass";
    exit;
}

$instance = new $controllerClass($request);

if (!method_exists($instance, $action)) {
    echo "Action not found: $action";
    exit;
}

call_user_func([$instance, $action]);
