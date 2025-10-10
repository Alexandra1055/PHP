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

    //podemos Crear funciones con nombre o anonimas
   $filtrarAutor = function ($books, $autor){
        $filtrarlibros = [];

        foreach ($books as $book){
            if($book['autor'] === $autor){
                $filtrarlibros[] = $book;
            }
        }
       return $filtrarlibros;
    }; //esto es lo que se conoce por funcion lambda
$filtrarlibros = filtrarAutor($books, 'J.K. Rowling');
?>
<ul>
    <?php foreach ($filtrarlibros as $book) :?>
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