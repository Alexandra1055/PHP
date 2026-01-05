<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        'guest'=> Guest::class,
        'auth' => Auth::class,
    ];

    public static function resolve($key){
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? null;

        if (!$middleware) {
            throw new \Exception("No se ha encontrado ningún middleware con la clave '{$key}'.");
        }
        (new $middleware)->handle();
    }
}
