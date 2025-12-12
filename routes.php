<?php

use Http\controllers\notes\NotesController;
use Http\controllers\SessionController;
use Http\controllers\UserController;


// HTML
$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contacto', 'contacto.php');

$router->get('/notes', [NotesController::class, 'index'])->only('auth');
$router->get('/note', [NotesController::class, 'show'])->only('auth');
$router->delete('/note', [NotesController::class, 'destroy'])->only('auth');

$router->get('/note/edit', [NotesController::class, 'edit'])->only('auth');
$router->patch('/note', [NotesController::class, 'update'])->only('auth');

$router->get('/notes/create', [NotesController::class, 'create'])->only('auth');
$router->post('/notes', [NotesController::class, 'store'])->only('auth');


$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->delete('/login', 'session/destroy.php')->only('auth');

// Rest API
$router->post('/api/session', [SessionController::class, 'apiLogin']);
$router->delete('/api/session', [SessionController::class, 'apiLogout']);
$router->delete('/api/session/all', [SessionController::class, 'apiLogoutAll']);

$router->post('/api/session/login', [SessionController::class, 'apiLogin']);
$router->post('/api/session/logout', [SessionController::class, 'apiLogout']);

//user endpoints donde el usuario puede ver y actualizar su propia informacion
$router->get('/api/users/me', [UserController::class, 'showMe']);
$router->patch('/api/users/me', [UserController::class, 'updateMe']);

//notas con rest
$router->get('/api/notes', [NotesController::class, 'index']);
$router->get('/api/note', [NotesController::class, 'show']);
$router->post('/api/notes', [NotesController::class, 'store']);
$router->put('/api/note', [NotesController::class, 'update']);
$router->delete('/api/note', [NotesController::class, 'destroy']);
