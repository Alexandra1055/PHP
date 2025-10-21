<?php
//conectamos nuestra MySQL database y ejecutamos una consulta y la construimos(RECORDAR __)

class DataBase{

    public $conexion;
    public function __construct(){
       // TODO esto es muy rigido, por lo quees mejor hacerlo mas flexible $dsn = "mysql:host=localhost;port=3306;dbname=myapp;user=root;charset=utf8mb4";

        $config = [
          'host' => 'localhost',
          'port' => '3306',
          'dbname' => 'myapp',
          'charset' => 'utf8mb4'
        ];

        http_build_query($data); //example.com?host=localhost?port=3306&dbname=myapp..

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

        $this-> conexion= new PDO($dsn, 'root','',[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    public function query($query){


        $declaracion= $this-> conexion->prepare($query);

        $declaracion->execute();

        return $declaracion;
    }
}