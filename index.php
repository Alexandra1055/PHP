<?php

require 'functions.php';

//require 'router.php';



require 'DataBase.php';

$db = new DataBase();
$posts =$db->query("SELECT * FROM posts where id=1")->fetchAll(PDO::FETCH_ASSOC);

dd($posts['title']);
