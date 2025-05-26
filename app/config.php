<?php
$dotenv = parse_ini_file(__DIR__ . '/../.env');

return [
    'host' => $dotenv['DB_HOST'],
    'port' => $dotenv['DB_PORT'],
    'db' => $dotenv['DB_NAME'],
    'user' => $dotenv['DB_USER'],
    'pass' => $dotenv['DB_PASSWORD']
];
