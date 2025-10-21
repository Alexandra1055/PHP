<?php

require "functions.php";

$uri = parse_url($_SERVER["REQUEST_URI"])['path'];

$router = [
    '/'=> 'controllers/index.php',
    '/about'=> 'controllers/about.php',
    '/contacto'=> 'controllers/contacto.php',
];

if(arry_key_exists($uri, $router)){
    require $router[$uri];
}