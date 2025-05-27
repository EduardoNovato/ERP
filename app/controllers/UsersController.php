<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/LoginHistory.php';

class UsersController
{
    public static function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }

        $db = Database::getConnection();

        // Obtener parámetros de búsqueda y filtros
        $search = $_GET['search'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Construir consulta con filtros
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE username LIKE :search OR email LIKE :search";
            $params['search'] = "%$search%";
        }

        // Obtener total de usuarios para paginación
        $countStmt = $db->prepare("SELECT COUNT(*) FROM users $whereClause");
        $countStmt->execute($params);
        $totalUsers = $countStmt->fetchColumn();
        $totalPages = ceil($totalUsers / $limit);

        // Obtener usuarios con paginación
        $stmt = $db->prepare("
            SELECT u.*, 
                   COUNT(al.id) as login_count,
                   MAX(al.login_time) as last_login
            FROM users u 
            LEFT JOIN auth_log al ON u.id = al.user_id 
            $whereClause
            GROUP BY u.id 
            ORDER BY u.created_at DESC 
            LIMIT :limit OFFSET :offset
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener estadísticas generales
        $stats = self::getUserStats();

        // Usar el nuevo sistema de layout
        View::renderWithLayout('users-content', [
            'users' => $users,
            'stats' => $stats,
            'search' => $search,
            'page' => $page,
            'totalPages' => $totalPages
        ], [
            'pageTitle' => 'Gestión de Usuarios',
            'currentPage' => 'users',
            'additionalCSS' => ['/assets/css/users.css'],
            'additionalJS' => ['/assets/js/users.js']
        ]);
    }

    public static function getUserStats()
    {
        $db = Database::getConnection();

        // Total de usuarios
        $totalUsers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

        // Usuarios activos (que han iniciado sesión en los últimos 30 días)
        $activeUsers = $db->query("
            SELECT COUNT(DISTINCT user_id) 
            FROM auth_log 
            WHERE login_time >= NOW() - INTERVAL '30 days'
        ")->fetchColumn();

        // Nuevos usuarios este mes
        $newThisMonth = $db->query("
            SELECT COUNT(*) 
            FROM users 
            WHERE DATE_TRUNC('month', created_at) = DATE_TRUNC('month', CURRENT_DATE)
        ")->fetchColumn();

        // Usuarios registrados hoy
        $newToday = $db->query("
            SELECT COUNT(*) 
            FROM users 
            WHERE created_at::date = CURRENT_DATE
        ")->fetchColumn();


        return [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'new_month' => $newThisMonth,
            'new_today' => $newToday
        ];
    }

    public static function delete()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }

        $userId = $_POST['user_id'] ?? null;
        if (!$userId) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de usuario requerido']);
            exit;
        }

        // No permitir que el usuario se elimine a sí mismo
        if ($userId == $_SESSION['user_id']) {
            http_response_code(400);
            echo json_encode(['error' => 'No puedes eliminarte a ti mismo']);
            exit;
        }

        $db = Database::getConnection();

        try {
            $db->beginTransaction();

            // Eliminar registros de auth_log primero
            $stmt = $db->prepare("DELETE FROM auth_log WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);

            // Eliminar usuario
            $stmt = $db->prepare("DELETE FROM users WHERE id = :user_id");
            $result = $stmt->execute(['user_id' => $userId]);

            $db->commit();

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al eliminar usuario']);
            }
        } catch (Exception $e) {
            $db->rollBack();
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
}
