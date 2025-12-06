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
use Http\controllers\notes\NotesController;
$controller = new NotesController();

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contacto', 'contacto.php');

$router->get('/notes', $controller->index())->only('auth');
$router->get('/note', $controller->show());
$router->delete('/note', $controller->destroy());

$router->get('/note/edit', $controller->edit());
$router->patch('/note', $controller->update());

$router->get('/notes/create', $controller->create());
$router->post('/notes', $controller->store());

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->delete('/login', 'session/destroy.php')->only('auth');
