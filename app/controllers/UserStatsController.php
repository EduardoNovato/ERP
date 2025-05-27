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

    // Método para obtener eventos recientes
    public static function getRecentEvents()
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT a.*, u.username 
            FROM auth_log a 
            JOIN users u ON a.user_id = u.id 
            ORDER BY a.login_time DESC 
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt = $db->query("SELECT TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count FROM users GROUP BY month ORDER BY month ASC");
        $usersByMonth = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['2025-04' => 3, '2025-05' => 1, etc.]

        // Inicios de sesión por día (últimos 7 días, para gráficas)
        $stmt = $db->query("
            SELECT DATE(login_time) as date, event_type, COUNT(*) as count
            FROM auth_log
            GROUP BY DATE(login_time), event_type
            ORDER BY DATE(login_time) DESC
            LIMIT 21
        ");
        $loginsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calcular estadísticas adicionales
        $totalUsers = array_sum($usersByMonth);

        // Calcular crecimiento de usuarios
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));

        $currentMonthUsers = $usersByMonth[$currentMonth] ?? 0;
        $lastMonthUsers = $usersByMonth[$lastMonth] ?? 0;

        $userGrowthPercentage = $lastMonthUsers > 0
            ? round(($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers * 100)
            : 0;

        // Obtener inicios de sesión de hoy y ayer
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $stmt = $db->prepare("SELECT COUNT(*) FROM auth_log WHERE DATE(login_time) = ?");
        $stmt->execute([$today]);
        $todayLogins = $stmt->fetchColumn();

        $stmt->execute([$yesterday]);
        $yesterdayLogins = $stmt->fetchColumn();

        // Obtener nuevos usuarios de hoy y ayer
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE DATE(created_at) = ?");
        $stmt->execute([$today]);
        $newUsersToday = $stmt->fetchColumn();

        $stmt->execute([$yesterday]);
        $newUsersYesterday = $stmt->fetchColumn();

        // Obtener eventos recientes para la sección de actividad
        $recentEvents = self::getRecentEvents();

        // Incluir helper de tiempo relativo
        if (file_exists(__DIR__ . '/../../helpers/timeRelative.php')) {
            require_once __DIR__ . '/../../helpers/timeRelative.php';
        }

        // Usar el nuevo sistema de layout
        View::renderWithLayout('dashboard-content', [
            'totalUsers' => $totalUsers,
            'userGrowthPercentage' => $userGrowthPercentage,
            'todayLogins' => $todayLogins,
            'yesterdayLogins' => $yesterdayLogins,
            'newUsersToday' => $newUsersToday,
            'newUsersYesterday' => $newUsersYesterday,
            'recentEvents' => $recentEvents,
            'usersByMonth' => $usersByMonth,
            'loginsData' => $loginsData
        ], [
            'pageTitle' => 'Dashboard',
            'currentPage' => 'dashboard',
            'includeChartJS' => true,
            'additionalJS' => ['/assets/js/quick-actions.js']
        ]);
    }
}
