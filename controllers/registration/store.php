<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST["email"];
$password = $_POST["password"];

$errors = [];

if(! Validator::email($email)) {
    $errors['email'] = 'Por favor, introduzca un correo electronico valido';
}
if(! Validator::string($password,7,255)) {
    $errors['password'] = 'La contraseña debe tener al menos 7 caracteres';
}

if(! empty($errors)) {
    return view('registration/create.view.php',[
        "errors" => $errors
    ]);
}

$db= App::resolve(Database::class);

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if($user) {
    header('location: /');
    exit();

}else{
    $db->query('insert into users(email, password) values (:email, :password)', [
        'email' => $email,
        'password' => $password
    ]);

    $_SESSION['user']= [
        'email' => $email
    ];
    header('location: /');
    exit();
}