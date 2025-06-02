<?php

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/View.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UserStatsController.php';
require_once __DIR__ . '/../app/controllers/UsersController.php';

$router = new Router();

// Página de inicio (formulario login)
$router->get('/', function () {
    View::render('auth/login');
});

// Página de registro
$router->get('/register', function () {
    View::render('auth/register');
});

// Acción: procesar formulario login
$router->post('/login', [AuthController::class, 'login']);

// Acción: procesar registro de usuario
$router->post('/register', [AuthController::class, 'register']);

// Acción: cerrar sesión
$router->get('/logout', [AuthController::class, 'logout']);

// Panel principal (restringido)
$router->get('/dashboard', [UserStatsController::class, 'dashboard']);

// Gestión de usuarios
$router->get('/users', [UsersController::class, 'index']);
$router->post('/users/delete', [UsersController::class, 'delete']);