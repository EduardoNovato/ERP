<?php

require_once __DIR__ . '/../models/LoginHistory.php';
require_once __DIR__ . '/../models/User.php';

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

    // Método para la ruta /dashboard sin parámetros
    public static function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Obtener estadísticas
        $loginCount = self::getLoginStats($userId);
        $lastLogin = self::getLastLoginDate($userId);
        $userInfo = self::getUserInfo($userId);

        // Obtener usuarios registrados por mes
        $db = Database::getConnection();
        $stmt = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM users GROUP BY month ORDER BY month ASC");
        $usersByMonth = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['2025-04' => 3, '2025-05' => 1, etc.]

        // Obtener inicios de sesión recientes (últimos 7 días)
        $stmt = $db->query("SELECT DATE(login_time) as date, COUNT(*) as count FROM auth_log GROUP BY DATE(login_time) ORDER BY DATE(login_time) DESC LIMIT 7");
        $loginsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../../views/dashboard.php';


    }

}
