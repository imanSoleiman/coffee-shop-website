<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$cart_id = $data['cart_id'] ?? 0;

if ($cart_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid cart ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $user_id]);
    echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
