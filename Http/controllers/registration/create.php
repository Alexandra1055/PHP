<?php
/* Si lo hacemos aqui, tendria que estar en mas sitios (duplicacion de codigo) por lo que lo configuramos desde el router
if($_SESSION['user'] ?? false){
    header('location: /');
    exit();
}
*/
view('registration/create.view.php');