<?php

require 'functions.php';

require 'router.php';

//conectamos nuestra MySQL database
$dsn = "mysql:host=localhost;port=3306;dbname=myapp;user=root;charset=utf8mb4";

$pdo= new PDO($dsn);

$declaracion= $pdo->prepare("SELECT * FROM posts");

$declaracion->execute();

$posts = $declaracion->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    echo "<li>" . $post['title'] . "</li>";
}
