
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