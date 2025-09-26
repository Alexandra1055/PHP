<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <style>
        body{
            display: grid;
            place-content: center;
            height: 100vh;
            margin: 0;
            font-family: sans-serif;
        }
    </style>
</head>
<body>
<h1>

    <?php
    /* Las Variables pueden hacerse con $nombreVariable*/
      //  $saludo = "Hola";
    /* Si usamos comilla simple, ' ', el texto aparece tal cual, con las comillas dobles interpreta lo que le pasamos*/
       // echo $saludo . " mundo";
    /* Es importante la refactorizacion del codigo para que ssea limpio*/
    ?>
</h1>
<?php
$nombre = "Dark Matter";
$read = false;

if ($read){
    $mensage = "No has leido $nombre";
}else{
    $mensage = "Has leido $nombre";
}
?>
<h1>
    <!--?php echo es lo mismo que usar solo ?=, asi es mas rapido -->
    ¿Has leido "<?php echo $nombre; ?>"?
    <?= $mensage ?>;
</h1>
</body>
</html>