<?php

class Validator { // son funciones puras, porque no dependen de nada por lo que podemos hacerlas staticas
    public static function string($value, $min = 1, $max = INF){
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }//ejemplo, queremos una contraseña de 7 caracteres minimo, pues ponemos min 7

    //ejemplos
    public static function email($value){
        //Validattor::email('ale@example.com')
        return filter_var($value, FILTER_VALIDATE_EMAIL); //asi si no es valida la direccion no lo devuelve
    }
}