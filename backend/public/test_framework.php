<?php
define('APP_PATH', __DIR__ . '/../application/');
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
define('APP_DEBUG', true);

require __DIR__ . '/../thinkphp/helpers.php';

require THINK_PATH . '/library/think/Loader.php';
require THINK_PATH . '/library/think/Config.php';
require THINK_PATH . '/library/think/Route.php';
require THINK_PATH . '/library/think/Controller.php';
require THINK_PATH . '/library/think/Model.php';
require THINK_PATH . '/library/think/View.php';
require THINK_PATH . '/library/think/Response.php';
require THINK_PATH . '/library/think/Db.php';

\think\Loader::register();
\think\Config::init();

try {
    echo "Framework loading...<br>";
    $db = \think\Db::instance();
    echo "DB connected!<br>";
    
    $admins = $db->table('admin')->select();
    echo "Admins count: " . count($admins) . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString();
}
