<?php

namespace Http\Forms;

class LoginForm{

    protected $errors = [];
    public function validate($email,$password){

        if (!Validator::email($email)) {
            $this->errors['email'] = 'Por favor, introduzca un correo electronico valido';
        }
        if (!Validator::string($password, 7, 255)) {
            $this->errors['password'] = 'La contraseña no es correcta';
        }
        return empty($this->errors);
    }

    public function errors(){
        return $this->errors;
    }

    public function error($field, $message){
        $this->errors[$field] = $message;
    }
}