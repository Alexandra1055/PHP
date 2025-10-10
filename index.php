
<?php
//este seria el archivo que hace las peticiones a api o bd

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
/*$filtrarAutor = function ($books, $autor){
     $filtrarlibros = [];

     foreach ($books as $book){
         if($book['autor'] === $autor){
             $filtrarlibros[] = $book;
         }
     }
    return $filtrarlibros;
 }; //esto es lo que se conoce por funcion lambda
$filtrarlibros = filtrarAutor($books, 'J.K. Rowling');*/

//funciones mas genericas
/*function filtrar ($items, $fn){ // con fn , que es como si dijera funcion, puedo hacer lo mismo que KEY/VALUE
    $filtrarItems = [];

    foreach ($items as $item){
        if($fn($item)){
            $filtrarItems[] = $item;
        }
    }
    return $filtrarItems;
};

$filtrarlibros = filtrar($books, function ($book){
    return $book['añoLanzamiento'] > 1999;
});*/

//funciones de PHP para hacer mas rapido lo que vimos
$filtrarlibros = array_filter($books, function ($book){
    return $book['añoLanzamiento'] > 1999;
});

//la etiqueta de cierre "? >" es redundante porque solo hay php en este documento,por lo que no necesitamos cerrarlo

require "index.view.php"; //para cargar los archivos de otro fichero