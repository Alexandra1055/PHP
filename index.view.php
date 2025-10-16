
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
<h1><?= $negocio['name']    ?></h1>
<ul>
    <?php foreach ($negocio['categories'] as $category): ?>
    <li><?= $category; ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>