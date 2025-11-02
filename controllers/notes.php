<?php
// controllers/notes.php

require_once __DIR__ . '/../DataBase.php';
$config = require __DIR__ . '/../config.php';

$db = new DataBase($config['database']);

$heading = 'My Notes';

$notes = $db->query('SELECT * FROM notes WHERE user_id = 1')->get();

require __DIR__ . '/../views/notes.view.php';
