<?php

namespace Core;

class Container
{
    protected $bindings = []; //enlaces
    public function bind($key, $resolver){ //-vincular, o podria ser add para añadir cosas
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key){ //-resolver o podria usar remove para eliminar si uso add arriba
        if(!array_key_exists($key, $this->bindings)){
            throw new \Exception('No se encontro un enlace para su clave: ' . $key);
        }
        $resolver = $this->bindings[$key];
        returncall_user_func($resolver);

    }
}