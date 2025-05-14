<?php
class Database
{
    private $pdo;

    public function __construct()
{
    $config = require __DIR__ . '/config.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";

    $maxAttempts = 10;
    $attempt = 0;

    while ($attempt < $maxAttempts) {
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            break;
        } catch (PDOException $e) {
            $attempt++;
            echo "Intentando conectar a la base de datos... intento $attempt\n";
            sleep(2); // espera 2 segundos antes del siguiente intento
        }
    }

    if (!$this->pdo) {
        throw new PDOException("No se pudo conectar a la base de datos después de $maxAttempts intentos.");
    }
}


    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
