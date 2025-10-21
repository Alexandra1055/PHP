<?php

require 'functions.php';

//require 'router.php';



//conectamos nuestra MySQL database y ejecutamos una consulta y la construimos(RECORDAR __)

class DataBase{

    public $conexion
    public function __construct(){
        $dsn = "mysql:host=localhost;port=3306;dbname=myapp;user=root;charset=utf8mb4";

        $this-> conexion= new PDO($dsn);
    }
    public function query($query){


        $declaracion= $this-> conexion->prepare($query);

        $declaracion->execute();

        return $declaracion->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new DataBase();
$posts =$db->query("SELECT * FROM posts where id=1");




foreach ($posts as $post) {
    echo "<li>" . $post['title'] . "</li>";
}
