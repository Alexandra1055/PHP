<?php

require 'functions.php';

//require 'router.php';



require 'DataBase.php';

$config = require('config.php');

$db = new DataBase($config['database']);

$posts =$db->query("SELECT * FROM posts where id=1")->fetchAll();

dd($posts['title']);
