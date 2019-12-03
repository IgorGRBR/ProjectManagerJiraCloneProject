<?php namespace core;

define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

class router {
    private $app        = 'form';
    private $controller = 'home';
    private $method     = 'base';
    private $params     = [];

    public function __construct() {

        $url        = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : [];
        $app        = array_shift($url);
        $controller = array_shift($url);
        $class      = $app . '\\controller\\' . $controller;

        if(class_exists($class)) {
            $this->app = $app;
            $this->controller = $controller;
        }
        
        $this->controller = $this->app . '\\controller\\' . $this->controller;
        $this->controller = new $this->controller;

        $method = array_shift($url);
        
        if(method_exists($this->controller, $method)) {
            $this->method = $method;
        }

        $this->params = array_values($url);
        if((new \ReflectionMethod($this->controller, $this->method))->getNumberOfParameters() == count($this->params)) {

            define('APP',  $this->app);
            define('SIGN', '_sign_');
            define('VIEW', 'apps' . DIRECTORY_SEPARATOR . APP . DIRECTORY_SEPARATOR .'view' . DIRECTORY_SEPARATOR);

            session::start();
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            router::redirect();
        }
    }

    public static function redirect($route = DIRECTORY_SEPARATOR) {
        http_response_code(302);
        header('Location: ' . $route);
    }
}