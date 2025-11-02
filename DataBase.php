<?php
//conectamos nuestra MySQL database y ejecutamos una consulta y la construimos(RECORDAR __)

class DataBase{

    public $conexion;
    public $statement;
    public function __construct($config, $username = 'root', $password = ''){
       // TODO esto es muy rigido, por lo quees mejor hacerlo mas flexible $dsn = "mysql:host=localhost;port=3306;dbname=myapp;user=root;charset=utf8mb4";

        $dsn = 'mysql:' .  http_build_query($config,'', ';'); //example.com?host=localhost?port=3306&dbname=myapp..

        $this-> conexion= new PDO($dsn, $username,$password,[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    public function query($query, $params = []){


        $this-> statement = $this-> conexion->prepare($query);

        $this-> statement ->execute($params);

        return $this;
    }

    public function find(){
        return $this-> statement -> fetch();
    }
}