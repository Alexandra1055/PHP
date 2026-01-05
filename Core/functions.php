<?php

use Core\Response;
use Core\RequestContext;

function dd($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function urlIs($value){
    return $_SERVER['REQUEST_URI'] === $value;
}

function is_api_request(): bool{
    return RequestContext::isApi();
}

function abort($code = 404){
    if (is_api_request()) {
        $message = 'Error';

        if ($code === Response::NOT_FOUND) {
            $message = 'Recurso no encontrado';
        } elseif ($code === Response::FORBIDDEN) {
            $message = 'Acceso denegado';
        } elseif ($code === Response::UNAUTHORIZED) {
            $message = 'No autenticado';
        }

        Response::json([
            'error' => $message,
            'code'  => $code,
        ], $code);
    }

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

function redirect($path){
    header("location: {$path}");
    exit();
}

function old($key, $default = ''){
    return \Core\Session::get('old')[$key] ?? $default;
}

function json_response($data, int $status = 200): void{
    Response::json($data, $status);
}

function get_bearer_token(): ?string{ // lee el token de autorización Bearer de las cabeceras HTTP
    if (!function_exists('getallheaders')) {
        return null;
    }

    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? $headers['authorization'] ?? null;

    if (!$auth) {
        return null;
    }

    if (stripos($auth, 'Bearer ') === 0) {
        return substr($auth, 7);
    }

    return null;
}