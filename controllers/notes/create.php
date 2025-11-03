<?php
require 'Database.php';
require 'Validator.php';
// require ('Validator.php'); se puede usar uno u otro, sirven igual

$config = require 'config.php';
$db = new Database($config['database']);

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //como es una funcion saica podemos llamarlo asi en lugar de darle un valor antes
    if(! Validator::string($_POST['body'],1,1000)){ //strlen longiud
        $errors['body'] = 'El texto debe tener maximo 1000 caracteres';
    }

    if(empty($errors)){
        $db ->query('INSERT INTO notes(body,user_id) VALUES(:body,:user_id)', [
                'body' => $_POST['body'],
                'user_id' => 1]
        );
    }
}

view("notes/create.view.php", [
    'heading' => 'Crear nota',
    'errors' => $errors
]);