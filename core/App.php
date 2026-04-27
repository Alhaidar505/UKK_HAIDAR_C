<?php
class App {
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){

        $url = $this->parseURL();

        // =========================
        // CONTROLLER HANDLING
        // =========================
        if(isset($url[0])){

            $controllerName = ucfirst($url[0]) . 'Controller';
            $file = '../app/controllers/' . $controllerName . '.php';

            if(file_exists($file)){
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // =========================
        // METHOD HANDLING
        // =========================
        if(isset($url[1])){

            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // =========================
        // PARAMETER HANDLING
        // =========================
        $this->params = $url ? array_values($url) : [];

        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );
    }

    // =========================
    // URL PARSER
    // =========================
    public function parseURL(){
        if(isset($_GET['url'])){
            return explode(
                '/',
                filter_var(
                    rtrim($_GET['url'], '/'),
                    FILTER_SANITIZE_URL
                )
            );
        }

        return [];
    }
}