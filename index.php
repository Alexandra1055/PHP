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
$mensage = "No has leido $nombre";
/*if ($read){
    $mensage = "No has leido $nombre";
}else{
    $mensage = "Has leido $nombre";
}*/
?>
<h1>
    <!--?php echo es lo mismo que usar solo ?=, asi es mas rapido -->
    ¿Has leido "<?php echo $nombre; ?>"?
    <?= $mensage ?>;
</h1>

<h1> Arrays: Libros recomendados</h1>
<?php

    $books = [
            "Harry Potter",
        "IT",
        "La torre oscura"
    ];
    ?>
<ul>
    <?php
    /*foreach ($books as $book) {
        echo "<li>$book</li>";*/
        //Abreviatura
        foreach ($books as $book) :?>
    <li><?php echo $book; // se puede abreviar mas?>
    <?= $book //esto seria mas abreviado?></li>
    <?php endforeach; ?>

</ul>
<h1>
    Arrays asociattivas
</h1>

<?php
    $books = [
      [
              'nombre' => 'Harry Potter y la piedra filosofal',
              'autor' => 'J.K. Rowling',
          'añoLanzamiento' => 1999,
            'UrlCompra' => 'https://www.ejemplo.com'
      ],
            [
                    'nombre' => 'I.T.',
                    'autor' => 'Stephen King',
                    'añoLanzamiento' => 1986,
                    'UrlCompra' => 'https://www.ejemplo.com'
            ],
            [
            'nombre' => 'La torre oscura',
            'autor' => 'Stephen King',
          'añoLanzamiento' => 1982,
            'UrlCompra' => 'https://www.ejemplo.com'
      ]//una array puede contener otras arrays, => es una matriz asociativa, asocia una clave con un valor
    ];

    function filtrarAutor($books, $autor){
        $filtrarlibros = [];

        foreach ($books as $book){
            if($book['autor'] === $autor){
                $filtrarlibros[] = $book;
            }
        }
       return $filtrarlibros;
    }
function filtrarByYear($books, $añoLanzamiento){
    $filtrarlibros = [];

    foreach ($books as $book){
        if($book['añoLanzamiento'] === $añoLanzamiento){
            $filtrarlibros[] = $book;
        }
    }
    return $filtrarlibros;
}
?>
<ul>
    <?php foreach (filtrarAutor($books, 'Stephen King') as $book) :?>
    <?php if ($book['autor']==='Stephen King'): //importante usar el triple = para comparar?>
    <li>
        <a href="<?= $book['UrlCompra'] ?>">
            <?=$book['nombre']; ?> (<?= $book['añoLanzamiento']; ?>) - By <?= $book['autor']; ?>
        </a>
    </li>
    <?php endif;?>
    <?php endforeach; ?>
</ul>
</body>
</html>