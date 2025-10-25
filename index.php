<?php

require 'functions.php';

//require 'router.php';



require 'DataBase.php';

$config = require('config.php');

$db = new DataBase($config['database']);

//hagamos mas seguro nuestro codigo para evitar que nos puedan eliminar datos de la db
$id = $_GET['id'];
$query = "select * from posts where id = ?"; //en lugar de declarar la variable, usamos ? o :id o cualquier cosa

$posts =$db->query($query,[$id])->fetch(); //si usamos ? no se pasa, pero si usamos :id pondremos [':id' => $id]

dd($posts[]);
