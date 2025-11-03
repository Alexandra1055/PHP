<?php
use Core\Database; //esto seria un alias de la ruta que quiero usar

$config = require base_path('config.php');
$db = new Database($config['database']);

$notes = $db->query('SELECT * FROM notes WHERE user_id = 1')->get();

view("notes/index.view.php", [
    'heading' => 'Mis Notas',
    'notes' => $notes
]);
