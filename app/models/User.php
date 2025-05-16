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

    public static function create($name, $email, $hashedPassword)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name'     => $name,
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
}
