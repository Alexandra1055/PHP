<?php

namespace Core;

class Session
{
    public static function has($key){
        return (bool) static::get($key);
    }
    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }
    public static function get($key, $default = null){
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash($key, $value){
        $_SESSION['_flash'][$key] = $value;
    }
    public static function unflash(){
        unset($_SESSION['_flash']); //unset es como, borrar esa clave de la sesion superglobal
    }

    public static function flush(){
        $_SESSION = [];
    }

    public static function destroy(){
        static::flush();
        session_destroy(); //destruimos el archivo de sesion

        $params = session_get_cookie_params(); //esto devuelve una array con la ruta y el domino de la sesion
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
//tiempo menos 1h, solo lo estas situando en el pasado. Podriamos omitir serure y httponly si queremos

    }

}