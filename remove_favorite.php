<?php
session_start();
require 'connection.php';
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$data = json_decode(file_get_contents('php://input'), true);
$item_id = $data['item_id'] ?? 0;

if (!$user_id || !$item_id) {
    echo json_encode(['status' => 'error']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id=? AND item_id=?");
if ($stmt->execute([$user_id, $item_id])) {
    echo json_encode(['status' => 'removed']);
} else {
    echo json_encode(['status' => 'error']);
}
