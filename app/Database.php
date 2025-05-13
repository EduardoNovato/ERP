<?php
class Database
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/config.php';
        $dns = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
        $this->pdo = new PDO($dns, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
