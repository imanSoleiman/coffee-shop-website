<?php
session_start();
require 'connection.php';

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message'=>'Login required']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$cart_id = $data['cart_id'] ?? 0;
$quantity = $data['quantity'] ?? 1;
$size = $data['size'] ?? 'small';
$total_price = $data['total_price'] ?? 0;

if($cart_id <= 0 || $quantity <= 0){
    echo json_encode(['status'=>'error','message'=>'Invalid data']);
    exit;
}

try{
    $stmt = $pdo->prepare("UPDATE cart SET quantity=?, size=?, total_price=? WHERE id=? AND user_id=?");
    $stmt->execute([$quantity, $size, $total_price, $cart_id, $user_id]);
    echo json_encode(['status'=>'success','message'=>'Cart updated']);
}catch(PDOException $e){
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>
