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

        // Get search parameters and filters
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $dateRange = $_GET['date_range'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Build query with filters
        $whereConditions = [];
        $params = [];

        if (!empty($search)) {
            $whereConditions[] = "(username LIKE :search OR email LIKE :search)";
            $params['search'] = "%$search%";
        }

        if ($status === 'active') {
            $whereConditions[] = "EXISTS (SELECT 1 FROM auth_log al WHERE al.user_id = u.id AND al.login_time >= NOW() - INTERVAL '30 days')";
        } elseif ($status === 'inactive') {
            $whereConditions[] = "NOT EXISTS (SELECT 1 FROM auth_log al WHERE al.user_id = u.id AND al.login_time >= NOW() - INTERVAL '30 days')";
        }

        if ($dateRange === 'week') {
            $whereConditions[] = "u.created_at >= NOW() - INTERVAL '7 days'";
        } elseif ($dateRange === 'month') {
            $whereConditions[] = "u.created_at >= NOW() - INTERVAL '30 days'";
        } elseif ($dateRange === 'year') {
            $whereConditions[] = "u.created_at >= NOW() - INTERVAL '1 year'";
        }

        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

        // Get total users for pagination
        $countStmt = $db->prepare("SELECT COUNT(*) FROM users u $whereClause");
        $countStmt->execute($params);
        $totalUsers = $countStmt->fetchColumn();
        $totalPages = ceil($totalUsers / $limit);

        // Get users with pagination
        $stmt = $db->prepare("
            SELECT u.*, 
                   COUNT(al.id) as login_count,
                   MAX(al.login_time) as last_login,
                   EXISTS (
                       SELECT 1 
                       FROM auth_log al2 
                       WHERE al2.user_id = u.id 
                       AND al2.login_time >= NOW() - INTERVAL '30 days'
                   ) as is_active
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

        // Get main statistics
        $activeUsers = $db->query("
            SELECT COUNT(DISTINCT user_id) 
            FROM auth_log 
            WHERE login_time >= NOW() - INTERVAL '30 days'
        ")->fetchColumn();

        $stats = [
            'total' => $totalUsers,
            'active' => $activeUsers
        ];

        View::renderWithLayout('users-content', [
            'users' => $users,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'dateRange' => $dateRange,
            'page' => $page,
            'totalPages' => $totalPages
        ], [
            'pageTitle' => 'Gestión de Usuarios',
            'currentPage' => 'users',
            'additionalCSS' => ['/assets/css/users.css'],
            'additionalJS' => ['/assets/js/users.js']
        ]);
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

        if ($userId == $_SESSION['user_id']) {
            http_response_code(400);
            echo json_encode(['error' => 'No puedes eliminarte a ti mismo']);
            exit;
        }

        $db = Database::getConnection();

        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("DELETE FROM auth_log WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);

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