<?php

require_once __DIR__ . '/../models/LoginHistory.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Database.php';

class UserStatsController
{
    public static function getLoginStats($userId)
    {
        return LoginHistory::getLoginCountByUser($userId);
    }

    public static function getLastLoginDate($userId)
    {
        return LoginHistory::getLastLoginByUser($userId);
    }

    public static function getUserInfo($userId)
    {
        return User::findById($userId);
    }

    public static function getRecentEvents(PDO $db)
    {
        $stmt = $db->query("
            SELECT u.username, u.email, l.event_type, l.login_time 
            FROM auth_log l
            JOIN users u ON u.id = l.user_id
            ORDER BY l.login_time DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $db = Database::getConnection();

        // Estadísticas básicas
        $loginCount = self::getLoginStats($userId);
        $lastLogin = self::getLastLoginDate($userId);
        $userInfo = self::getUserInfo($userId);

        // Usuarios por mes (para gráficas)
        $stmt = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM users GROUP BY month ORDER BY month ASC");
        $usersByMonth = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Inicios de sesión por día (últimos 7 días, para gráficas)
        $stmt = $db->query("
            SELECT DATE(login_time) as date, event_type, COUNT(*) as count
            FROM auth_log
            GROUP BY DATE(login_time), event_type
            ORDER BY DATE(login_time) DESC
            LIMIT 21
        ");
        $loginsData = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Total usuarios
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $totalUsers = $stmt->fetchColumn();

        // Nuevos usuarios hoy y ayer
        $stmt = $db->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()");
        $newUsersToday = $stmt->fetchColumn();

        $stmt = $db->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY");
        $newUsersYesterday = $stmt->fetchColumn();

        // Cálculo de crecimiento
        $userGrowthPercentage = 0;
        if ($newUsersYesterday > 0) {
            $userGrowthPercentage = round((($newUsersToday - $newUsersYesterday) / $newUsersYesterday) * 100, 2);
        } elseif ($newUsersToday > 0) {
            $userGrowthPercentage = 100;
        }

        // Inicios de sesión hoy y ayer
        $stmt = $db->query("SELECT COUNT(*) FROM auth_log WHERE DATE(login_time) = CURDATE()");
        $todayLogins = $stmt->fetchColumn();

        $stmt = $db->query("SELECT COUNT(*) FROM auth_log WHERE DATE(login_time) = CURDATE() - INTERVAL 1 DAY");
        $yesterdayLogins = $stmt->fetchColumn();

        // Eventos recientes
        $recentEvents = self::getRecentEvents($db);

        // Renderizar vista
        require __DIR__ . '/../../views/dashboard.php';
    }
}
