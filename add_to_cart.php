<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login first']);
    exit;
}

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);

$item_id = $data['item_id'] ?? 0;
$quantity = $data['quantity'] ?? 1;
$size = $data['size'] ?? 'small';
$total_price = $data['total_price'] ?? $data['price'] ?? 0;

if ($item_id <= 0 || $quantity <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, quantity, total_price FROM cart WHERE user_id=? AND item_id=? AND size=?");
    $stmt->execute([$user_id, $item_id, $size]);
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {

        $new_quantity = $cartItem['quantity'] + $quantity;
        $new_total = $cartItem['total_price'] + $total_price;
        $update = $pdo->prepare("UPDATE cart SET quantity=?, total_price=?, added_at=NOW() WHERE id=?");
        $update->execute([$new_quantity, $new_total, $cartItem['cart_id']]);
    } else {

        $insert = $pdo->prepare("INSERT INTO cart (user_id,item_id,quantity,size,total_price) VALUES(?,?,?,?,?)");
        $insert->execute([$user_id, $item_id, $quantity, $size, $total_price]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Added to cart!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
