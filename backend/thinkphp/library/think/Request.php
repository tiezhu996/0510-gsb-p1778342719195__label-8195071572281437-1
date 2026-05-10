<?php
namespace think;

class Request {
    protected $method;
    protected $pathinfo;
    protected $module;
    protected $controller;
    protected $action;
    protected $dispatch = [];
    protected static $instance;
    
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->method = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
        $this->pathinfo = $_SERVER['PATH_INFO'] ?? '/';
    }
    
    public function pathinfo() {
        if ($this->pathinfo === '/' || empty($this->pathinfo)) {
            $this->pathinfo = $_SERVER['REQUEST_URI'] ?? '/';
            $this->pathinfo = strtok($this->pathinfo, '?');
        }
        return $this->pathinfo;
    }
    
    public function dispatch() {
        if (empty($this->dispatch)) {
            $path = trim($this->pathinfo, '/');
            $parts = explode('/', $path);
            
            $this->module = isset($parts[0]) ? $parts[0] : 'admin';
            $rawController = isset($parts[1]) ? $parts[1] : 'console';
            $this->action = isset($parts[2]) ? $parts[2] : 'index';
            
            // Convert snake_case to CamelCase
            $this->controller = str_replace('_', '', ucwords($rawController, '_'));
            
            $this->dispatch = [
                'type' => 'module',
                'module' => [$this->module, $this->controller, $this->action]
            ];
        }
        return $this->dispatch;
    }
    
    public function module($module = null) {
        if (is_null($module)) {
            return $this->module;
        }
        $this->module = $module;
    }
    
    public function controller($controller = null) {
        if (is_null($controller)) {
            $this->dispatch();
            return $this->controller;
        }
        $this->controller = $controller;
    }
    
    public function action($action = null) {
        if (is_null($action)) {
            $this->dispatch();
            return $this->action;
        }
        $this->action = $action;
    }
    
    public function param($name = '', $default = null) {
        if (empty($name)) {
            return array_merge($_GET, $_POST);
        }
        return isset($_POST[$name]) ? $_POST[$name] : (isset($_GET[$name]) ? $_GET[$name] : $default);
    }
    
    public function isPost() {
        return $this->method === 'post';
    }
    
    public function isGet() {
        return $this->method === 'get';
    }
    
    public function isAjax() {
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
    }
}
