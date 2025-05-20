<?php

require_once __DIR__ . '/../core/Database.php';

class User
{
    public static function findByEmail($email)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByUsername($username)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($username, $email, $hashedPassword)
    {
        $db = Database::getConnection();

        // Verificar que no exista un usuario con el mismo email o username
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
        $stmt->execute([
            'email' => $email,
            'username' => $username
        ]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            return false; // Ya existe un usuario con ese email o username
        }

        // Insertar nuevo usuario
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword
        ]);
    }

    public static function findById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function recordFailedLogin(string $username)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_login = NOW() WHERE username = :username");
        $stmt->execute(['username' => $username]);
        
        // Verificar si se debe bloquear
        $stmt = $pdo->prepare("SELECT failed_attempts FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && $user['failed_attempts'] >= 5) {
            $lockTime = date('Y-m-d H:i:s', strtotime('+30 minutes'));
            $stmt = $pdo->prepare("UPDATE users SET account_locked_until = :lockTime WHERE username = :username");
            $stmt->execute(['lockTime' => $lockTime, 'username' => $username]);
        }
    }

    public static function resetLoginAttempts(int $userId): void {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET failed_attempts = 0, account_locked_until = NULL WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public static function isAccountLocked(string $username): ?string {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT account_locked_until FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch();

        if ($result && $result['account_locked_until'] && strtotime($result['account_locked_until']) > time()) {
            return $result['account_locked_until']; // Fecha y hora hasta la cual está bloqueada
        }
        return null;
    }
}
