<?php

$dotenv = parse_ini_file(__DIR__ . '/../.env');

return [
    'host'    => $dotenv['DB_HOST'] ?? 'localhost',
    'db'      => $dotenv['MYSQL_DATABASE'] ?? 'login_app',
    'user'    => 'root', // Ya sabemos que usas root y no defines otro usuario
    'pass'    => $dotenv['MYSQL_PASSWORD'] ?? 'root',
    'charset' => $dotenv['DB_CHARSET'] ?? 'utf8mb4',
];
