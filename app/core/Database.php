<?php
class Database
{
    private static $pdo = null;

    public static function getConnection(): PDO
    {
        if (!self::$pdo) {
            $config = require __DIR__ . '/../config.php';

            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['db']}";

            $maxAttempts = 10;
            $attempt = 0;

            while ($attempt < $maxAttempts) {
                try {
                    self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
                    break;
                } catch (PDOException $e) {
                    $attempt++;
                    sleep(2);
                }
            }

            if (!self::$pdo) {
                throw new PDOException("No se pudo conectar a la base de datos después de $maxAttempts intentos.");
            }
        }

        return self::$pdo;
    }
}
