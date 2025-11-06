<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db= App::resolve(Database::class);

$email = $_POST["email"];
$password = $_POST["password"];


$errors = [];

if(! Validator::email($email)) {
    $errors['email'] = 'Por favor, introduzca un correo electronico valido';
}
if(! Validator::string($password,7,255)) {
    $errors['password'] = 'La contraseña no es correcta';
}

if(! empty($errors)) {
    return view('sessions/create.view.php',[
        "errors" => $errors
    ]);
}

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if($user) {
    //para verificar nuestra contraseña encriptada
    if(password_verify($password, $user['password'])) {
        login(['email' => $email]);

        header('location: /');
        exit();
    }
}



return view('sessions/create.view.php',[
    'errors' => [
        'email' => ['No se encontro un correo para este usuario']
    ]
]);

