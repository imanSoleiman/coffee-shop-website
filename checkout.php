<?php
session_start();
require 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cartItems) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit;
}

$pdo->beginTransaction();

try {
    $totalPayment = 0;
    $orderDate = date('Y-m-d H:i:s');

    $insertOrder = $pdo->prepare("INSERT INTO orders (user_id, item_id, quantity, total_price, order_date) VALUES (?, ?, ?, ?, ?)");

    foreach ($cartItems as $item) {
        $insertOrder->execute([
            $user_id,
            $item['item_id'],
            $item['quantity'],
            $item['total_price'],
            $orderDate
        ]);
        $totalPayment += $item['total_price'];
    }
    $deleteCart = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $deleteCart->execute([$user_id]);

    $pdo->commit();

    echo json_encode(['status' => 'success', 'total' => $totalPayment]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
