<?php
require_once __DIR__ . '/../../app/Database.php';

$db = new Database();
$pdo = $db->getConnection();

$sql = "
    SELECT DATE(login_time) as date, COUNT(*) as count
    FROM auth_log
    GROUP BY DATE(login_time)
    ORDER BY DATE(login_time) DESC
    LIMIT 7
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($data);
