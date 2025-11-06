<?php

use Core\Response;

function dd($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function urlIs($value){
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);
    require base_path("views/{$code}.php");

    die();
}
function authorize($condition, $status = Response::FORBIDDEN){
    if(!$condition){
        abort($status);
    }
}

function base_path($path){
    return BASE_PATH . $path;
}

function view($path, $attributes = []){
    extract($attributes);
    require base_path('views/' . $path);
}

function login($user){
    $_SESSION['user']= [
        'email' => $user['email']
    ];

    session_regenerate_id(true);
}

function logout(){
    $_SESSION=[]; //vaciamos

    session_destroy(); //destruimos el archivo de sesion

    $params = session_get_cookie_params(); //esto devuelve una array con la ruta y el domino de la sesion
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
//tiempo menos 1h, solo lo estas situando en el pasado. Podriamos omitir serure y httponly si queremos

}
