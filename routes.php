<?php
/*
 return [
    '/'=> 'index.php',
    '/about'=> 'about.php',
    '/notes'=> 'notes/index.php',
    '/note'=> 'notes/show.php',
    '/notes/create'=> 'notes/create.php',
    '/contacto'=> 'contacto.php',
];

 */

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contacto', 'contacto.php');

$router->get('/notes', 'notes/index.php')->only('auth');
$router->get('/note', 'notes/show.php');
$router->delete('/note', 'notes/destroy.php');

$router->get('/note/edit', 'notes/edit.php');
$router->patch('/note', 'notes/update.php');

$router->get('/notes/create', 'notes/create.php');
$router->post('/notes', 'notes/store.php');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->delete('/login', 'session/destroy.php')->only('auth');
