<?php
use Core\Database; //esto seria un alias de la ruta que quiero usar
use Core\App;

$db = App::resolve(Database::class);

$notes = $db->query('SELECT * FROM notes WHERE user_id = 1')->get();

view("notes/index.view.php", [
    'heading' => 'Mis Notas',
    'notes' => $notes
]);
