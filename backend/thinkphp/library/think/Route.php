<?php
namespace think;

class Route {
    protected static $rules = [];
    
    public static function get($rule, $route = null) {
        self::$rules['get'][$rule] = $route;
    }
    
    public static function post($rule, $route = null) {
        self::$rules['post'][$rule] = $route;
    }
    
    public static function any($rule, $route = null) {
        self::$rules['any'][$rule] = $route;
    }
    
    public static function build($url, $vars = '', $suffix = true, $domain = false) {
        return $url;
    }
}
