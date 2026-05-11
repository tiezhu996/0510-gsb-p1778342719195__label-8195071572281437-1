<?php
// ThinkPHP 引导文件
define('THINK_PATH', __DIR__);
define('CORE_PATH', THINK_PATH . '/library/');
define('EXTEND_PATH', THINK_PATH . '/extend/');
define('MODE_PATH', THINK_PATH . '/mode/');
define('VENDOR_PATH', THINK_PATH . '/vendor/');
define('RUNTIME_PATH', APP_PATH . '/../runtime/');
define('LOG_PATH', RUNTIME_PATH . 'logs/');
define('CACHE_PATH', RUNTIME_PATH . 'cache/');
define('TEMP_PATH', RUNTIME_PATH . 'temp/');

define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    if (strpos($class, 'app/') === 0) {
        $relativePath = substr($class, 4);
        $file = APP_PATH . $relativePath . '.php';
        if (is_file($file)) {
            include $file;
            return true;
        }
    }
    $file = EXTEND_PATH . $class . '.php';
    if (is_file($file)) {
        include $file;
        return true;
    }
    $file = CORE_PATH . $class . '.php';
    if (is_file($file)) {
        include $file;
        return true;
    }
    return false;
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function ($e) {
    echo $e->getMessage();
    exit;
});

function C($name = null, $value = null, $default = null) {
    static $config = [];
    if (is_null($name)) {
        return $config;
    }
    if (is_string($name)) {
        $name = strtolower($name);
        if (is_null($value)) {
            return isset($config[$name]) ? $config[$name] : $default;
        }
        $config[$name] = $value;
        return;
    }
    if (is_array($name)) {
        $config = array_merge($config, array_change_key_case($name));
        return;
    }
    return $config;
}

function M($name = '') {
    $class = '\\app\\common\\model\\' . ucfirst($name);
    if (!class_exists($class)) {
        $class = '\\think\\Model';
    }
    return new $class($name);
}

function I($name, $default = null, $filter = '') {
    return input($name, $default, $filter);
}

function url($url = '', $vars = '', $suffix = true, $domain = false) {
    return \think\Url::build($url, $vars, $suffix, $domain);
}

function session($name, $value = '') {
    if (is_null($name)) {
        return session_destroy();
    }
    if (is_array($name)) {
        foreach ($name as $key => $val) {
            $_SESSION[$key] = $val;
        }
        return true;
    }
    if ('' === $value) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }
    $_SESSION[$name] = $value;
    return true;
}

function redirect($url = '', $vars = [], $status = 302) {
    return \think\Response::redirect($url, $vars, $status);
}

function exception($msg, $code = 0, $exception = '') {
    $e = $exception ? new $exception($msg, $code) : new \Exception($msg, $code);
    throw $e;
}

function halt($var) {
    dump($var);
    exit;
}

function vendor($class) {
    $vendor = VENDOR_PATH . str_replace('\\', '/', $class) . '.php';
    if (is_file($vendor)) {
        include $vendor;
    }
}

function dump($var, $echo = true, $label = null) {
    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
    if (IS_CLI) {
        $output = PHP_EOL . $label . $output . PHP_EOL;
    } else {
        if (!extension_loaded('xdebug')) {
            $output = htmlspecialchars($output, ENT_QUOTES);
        }
        $output = '<pre>' . $label . $output . '</pre>';
    }
    if ($echo) {
        echo $output;
        return null;
    }
    return $output;
}

function input($key = null, $default = null, $filter = '') {
    static $params = [];
    if (is_null($key)) {
        return $params;
    }
    if ($pos = strpos($key, '.')) {
        $method = substr($key, 0, $pos);
        $keys = substr($key, $pos + 1);
    } else {
        $method = 'param';
        $keys = $key;
    }
    $params[$method][$keys] = $default;
    return $params[$method][$keys];
}
