<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        'guest' => GUEST::class,
        'auth' => AUTH::class
    ];

    public static function resolve($key){
        if(!$key){
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if(!$middleware){
            return \Exception("No se ha encontrado ningun middleware con la clave '{$key}'.");
        }

        (new $middleware)->handle();
    }
}