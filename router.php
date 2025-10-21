<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$router = [
    '/'=> 'controllers/index.php',
    '/about'=> 'controllers/about.php',
    '/contacto'=> 'controllers/contacto.php',
];

function routeToController($uri,$router)
{
    if(array_key_exists($uri, $router)){
        require $router[$uri];
    }else{
        abort();
    }
}

function abort($code = 404)
{
    http_response_code($code);
    require "views/{$code}.php";

    die();
}

routeToController($uri,$router);
