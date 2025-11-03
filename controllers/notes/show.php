<?php

$config = require base_path('config.php');
$db = new Database($config['database']);

$currentUserId = 1;


$note = $db->query('select * from notes where id = :id', [
    'id' => $_GET['id']
])->findOrFail();


authorize($note['user_id'] === $currentUserId);


require "views/notes/show.view.php";

view("notes/index.view.php", [
    'heading' => 'Nota',
    'note' => $note,
]);