<?php

use Core\Authenticator;
use Http\Forms\LoginForm;


$form = LoginForm::validate($atributes =[
    'email' => $_POST["email"],
    'password' => $_POST["password"]
]);

$signedIn = (new Authenticator) -> attempt(
    $atributes['email'], $atributes['password']
);

if(!$signedIn){
    $form -> error(
        'email','No se ha encontrado una cuenta con ese correo o contraseña'
    )->throw();
}
redirect('/');










