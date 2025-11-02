<?php
$heading = 'Crear Nota';

$config = require ('config.php');

$db = new DataBase($config['database']);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];

    if(strlen($_POST['body']) == 0){ //strlen longiud
        $errors['body'] = 'El texto es obligatorio';
    }

    if(strlen($_POST['body']) > 1000){ //maximo de caracters
        $errors['body'] = 'El texto no puede superar los 1000 caracteres';
    }

    if(empty($errors)){
        $db ->query('INSERT INTO notes(body,user_id) VALUES(:body,:user_id)', [
                'body' => $_POST['body'],
                'user_id' => 1]
        );
    }
}

require 'views/note-create.view.php';