<?php

namespace Core;
use Core\Middleware\Auth;
use Core\Middleware\Guest;
use Core\Middleware\Middleware;

class Router{
    protected $routes=[];

    public function add($method,$uri,$controller){

        $this->routes[]=[
            'uri'=>$uri,
            'controller'=>$controller,
            'method' => strtoupper($method),
            'middleware' => null,
            'request'=> 'web' //web por defecto
        ];

        return $this;
    }
    public function get($uri, $controller){
        return $this -> add('GET', $uri, $controller);
    }
    public function post($uri, $controller){
        return $this -> add('POST', $uri, $controller);
    }

    public function delete($uri, $controller){
        return $this -> add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller){
        return $this -> add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller){
        return $this -> add('PUT', $uri, $controller);
    }
    public function only($key){
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    public function request(string $type){
        $type = strtolower($type);
        if (!in_array($type, ['api', 'web'], true)) {
            throw new \InvalidArgumentException("request() solo acepta 'api' o 'web'.");
        }

        $this->routes[array_key_last($this->routes)]['request'] = $type;
        return $this;
    }

    public function route($uri, $method){
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                RequestContext::setIsApi(($route['request'] ?? 'web') === 'api');
                if ($route['middleware']) {
                    Middleware::resolve($route['middleware']);
                }

                if (is_array($route['controller'])) {
                    $controller = new $route['controller'][0]();
                    $m = $route['controller'][1];
                    return $controller->$m();
                }

                return require base_path('Http/controllers/' . $route['controller']);
            }
        }

        $this->abort();
    }

    public function previusUrl(){
        return $_SERVER['HTTP_REFERER'] ?? '/';
    }

    protected function abort($code = 404){
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
}


