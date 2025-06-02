<?php

require_once __DIR__ . '/../app/core/Router.php';  // Nueva ruta
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../app/core/View.php';

$router->resolve();
