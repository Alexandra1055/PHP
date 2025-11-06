<?php

namespace Core;

class ValidatonException extends \Exception{ //hereda de esta clase ya existente
    //en lugar de esto podria hacer protected $errors=[]; y abajo la funcion get
    //    public function errors(){
    //        return $this->errors;
    //    }
    public readonly array $errors;
    public readonly array $old;
    public static function throw($errors, $old){
        $instance = new static;
        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }


}