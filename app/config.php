<?php
$dotenv = parse_ini_file(__DIR__ . '/../.env');

return [
    'host'    => $dotenv['DB_HOST'],
    'db'      => $dotenv['DB_NAME'],
    'user'    => $dotenv['DB_USER'],
    'pass'    => $dotenv['DB_PASS'],
    'charset' => $dotenv['DB_CHARSET'],
];
