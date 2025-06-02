<?php

require_once __DIR__ . '/../core/Database.php';

class LoginHistory
{
    public static function log($userId, $ipAddress, $eventType = 'login')
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO auth_log (user_id, ip_address, event_type, login_time) VALUES (:user_id, :ip_address, :event_type, NOW())");
        return $stmt->execute([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'event_type' => $eventType
        ]);
    }

    public static function getLoginCountByUser($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM auth_log WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public static function getLastLoginByUser($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT login_time FROM auth_log WHERE user_id = :user_id ORDER BY login_time DESC LIMIT 1");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['login_time'] ?? null;
    }
}
