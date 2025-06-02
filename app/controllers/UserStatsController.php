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
            LIMIT 8
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
        $db = Database::getConnection();

        // Obtener usuarios registrados por mes (últimos 12 meses)
        $stmt = $db->query("
            SELECT TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count 
            FROM users 
            WHERE created_at >= (CURRENT_DATE - INTERVAL '12 months')
            GROUP BY month 
            ORDER BY month ASC
        ");
        $usersByMonth = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Calcular estadísticas principales
        $totalUsers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

        // Usuarios activos (últimos 30 días)
        $activeUsers = $db->query("
            SELECT COUNT(DISTINCT user_id) 
            FROM auth_log 
            WHERE login_time >= (CURRENT_DATE - INTERVAL '30 days')

        ")->fetchColumn();

        // Nuevos usuarios este mes
        $newUsersThisMonth = $db->query("
            SELECT COUNT(*) 
            FROM users 
            WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE)
            AND EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)

        ")->fetchColumn();

        // Calcular crecimiento de usuarios (comparar con mes anterior)
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));

        $currentMonthUsers = $usersByMonth[$currentMonth] ?? 0;
        $lastMonthUsers = $usersByMonth[$lastMonth] ?? 0;

        $userGrowthPercentage = $lastMonthUsers > 0
            ? round(($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers * 100)
            : 0;

        // Obtener eventos recientes para la sección de actividad
        $recentEvents = self::getRecentEvents();

        // Incluir helper de tiempo relativo
        if (file_exists(__DIR__ . '/../../helpers/timeRelative.php')) {
            require_once __DIR__ . '/../../helpers/timeRelative.php';
        }

        // Usar el nuevo sistema de layout
        View::renderWithLayout('dashboard-content', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'userGrowthPercentage' => $userGrowthPercentage,
            'recentEvents' => $recentEvents,
            'usersByMonth' => $usersByMonth
        ], [
            'pageTitle' => 'Dashboard',
            'currentPage' => 'dashboard',
            'includeChartJS' => true,
            'additionalCSS' => ['/assets/css/dashboard.css'],
            'additionalJS' => ['/assets/js/dashboard-actions.js']
        ]);
    }
}
