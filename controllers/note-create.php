<?php
$heading = 'Crear Nota';

$config = require ('config.php');

$db = new DataBase($config['database']);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];

    if(strlen($_POST['body']) == 0){
        $errors['body'] = 'El texto es obligatorio';
    }

    if(empty($errors)){
        $db ->query('INSERT INTO notes(body,user_id) VALUES(:body,:user_id)', [
                'body' => $_POST['body'],
                'user_id' => 1]
        );
    }
}

require 'views/note-create.view.php';