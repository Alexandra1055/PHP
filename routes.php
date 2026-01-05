<?php

use Http\controllers\notes\NotesController;
use Http\controllers\SessionController;
use Http\controllers\UserController;

// WEB (por defecto es 'web')
$router->get('/', 'index.php')->request('web');
$router->get('/about', 'about.php')->request('web');
$router->get('/contacto', 'contacto.php')->request('web');

$router->get('/notes', [NotesController::class, 'index'])->only('auth')->request('web');
$router->get('/note', [NotesController::class, 'show'])->only('auth')->request('web');
$router->delete('/note', [NotesController::class, 'destroy'])->only('auth')->request('web');

$router->get('/note/edit', [NotesController::class, 'edit'])->only('auth')->request('web');
$router->patch('/note', [NotesController::class, 'update'])->only('auth')->request('web');

$router->get('/notes/create', [NotesController::class, 'create'])->only('auth')->request('web');
$router->post('/notes', [NotesController::class, 'store'])->only('auth')->request('web');

$router->get('/register', 'registration/create.php')->only('guest')->request('web');
$router->post('/register', 'registration/store.php')->only('guest')->request('web');

$router->get('/login', 'session/create.php')->only('guest')->request('web');
$router->post('/login', 'session/store.php')->only('guest')->request('web');
$router->delete('/login', 'session/destroy.php')->only('auth')->request('web');


// API REST (autenticación por tokens)

// Login sin auth
$router->post('/api/session/login', [SessionController::class, 'apiLogin'])->request('api');

// Logout con auth
$router->delete('/api/session', [SessionController::class, 'apiLogout'])->only('auth')->request('api');

// Logout all tokens
$router->delete('/api/session/all', [SessionController::class, 'apiLogoutAll'])->only('auth')->request('api');

// Usuario
$router->get('/api/users/me', [UserController::class, 'showMe'])->only('auth')->request('api');
$router->patch('/api/users/me', [UserController::class, 'updateMe'])->only('auth')->request('api');

// Notas API
$router->get('/api/notes', [NotesController::class, 'index'])->only('auth')->request('api');
$router->get('/api/note', [NotesController::class, 'show'])->only('auth')->request('api');
$router->post('/api/notes', [NotesController::class, 'store'])->only('auth')->request('api');
$router->put('/api/note', [NotesController::class, 'update'])->only('auth')->request('api');
$router->delete('/api/note', [NotesController::class, 'destroy'])->only('auth')->request('api');
