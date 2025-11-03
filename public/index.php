<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    //Core\Database
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class); //directory separator, en nuestro caso es /, pero para que funcione en cualquier navegador usamos esta variable
    require  base_path("{$class}.php");
});

require base_path('Core/router.php');