<?php
require_once __DIR__ . '/../../app/Database.php';

$db = new Database();
$pdo = $db->getConnection();

// Obtenemos todos los periodos existentes en orden
$stmt = $pdo->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM users GROUP BY month ORDER BY month ASC");
$data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['2025-04' => 3, '2025-05' => 1, etc.]

header('Content-Type: application/json');
echo json_encode($data);
