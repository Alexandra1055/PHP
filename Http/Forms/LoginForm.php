<?php

namespace Http\Forms;

use Cassandra\Exception\ValidationException;
use Core\Validator;

class LoginForm{

    public array $atributes;
    protected array $errors = [];

    public function __construct(array $atributes){
        $this->atributes = $atributes;

        if (!Validator::email($atributes['email'])) {
            $this->errors['email'] = 'Por favor, introduzca un correo electronico valido';
        }
        if (!Validator::string($atributes['password'])) {
            $this->errors['password'] = 'La contraseña no es correcta';
        }
    }

    public static function validate($atributes){
        $instance = new static($atributes);
        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw(){
        ValidatonException::throw($this->errors(), $this->atributes);
    }

    public function failed(){
        return count($this->errors) > 0;
    }

    public function errors(){
        return $this->errors;
    }

    public function error($field, $message){
        $this->errors[$field] = $message;
        return $this;
    }
}