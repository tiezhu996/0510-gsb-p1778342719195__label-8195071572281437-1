<?php
define('APP_PATH', __DIR__ . '/../application/');
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
define('APP_DEBUG', true);

require __DIR__ . '/../thinkphp/helpers.php';

\think\Config::init();

$request = \think\Request::instance();
$path = $request->pathinfo();
echo "Path: $path<br>";

$parts = explode('/', trim($path, '/'));
echo "Module: " . ($parts[0] ?? 'admin') . "<br>";
echo "Controller: " . ($parts[1] ?? 'console') . "<br>";
echo "Action: " . ($parts[2] ?? 'index') . "<br>";

// Try to load the controller
$controllerClass = '\\app\\admin\\controller\\Console';
if (class_exists($controllerClass)) {
    echo "Controller class exists!<br>";
    $controller = new $controllerClass($request);
    echo "Controller instantiated!<br>";
    
    // Try to call index
    echo "Calling index action...<br>";
    $response = $controller->index();
} else {
    echo "Controller class NOT found: $controllerClass<br>";
    
    // List the files
    echo "Listing controllers:<br>";
    $files = glob(APP_PATH . 'admin/controller/*.php');
    foreach ($files as $f) {
        echo basename($f) . "<br>";
    }
}
