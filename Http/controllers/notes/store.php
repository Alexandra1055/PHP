<?php

use Core\Database;
use Core\Validator;
use Core\App;

$db = App::resolve(Database::class);

$errors = [];
//como es una funcion saica podemos llamarlo asi en lugar de darle un valor antes
if(! Validator::string($_POST['body'],1,1000)){ //strlen longiud
    $errors['body'] = 'El texto debe tener maximo 1000 caracteres';
}

if(!empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Crear nota',
        'errors' => $errors
    ]);
}

$db ->query('INSERT INTO notes(body,user_id) VALUES(:body,:user_id)', [
        'body' => $_POST['body'],
        'user_id' => 1]
);

header("location: /notes");
die();


