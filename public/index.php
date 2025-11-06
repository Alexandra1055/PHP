<?php
session_start();
const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    //Core\Database
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class); //directory separator, en nuestro caso es /, pero para que funcione en cualquier navegador usamos esta variable
    require base_path("{$class}.php");
});

require base_path('bootstrap.php');

$router = new \Core\Router();


$routes = require base_path('routes.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$method = $_POST['method'] ?? $_SERVER['REQUEST_METHOD']; //operador ternario nuevo

$router -> route($uri, $method);