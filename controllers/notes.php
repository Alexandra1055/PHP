<?php


$config = require('config.php');

$db = new DataBase($config['database']);

$heading = 'My Notes';

$notes= $db->query('SELECT * FROM notes WHERE user_id = 1') -> get();

require "views/notes.view.php";