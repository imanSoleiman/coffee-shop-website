<?php
session_start();
require 'connection.php';
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$data = json_decode(file_get_contents('php://input'), true);
$item_id = $data['item_id'] ?? 0;

if(!$user_id || !$item_id){
    echo json_encode(['status'=>'error']); exit;
}

// Check if favorite exists
$stmt = $pdo->prepare("SELECT 1 FROM favorites WHERE user_id=? AND item_id=?");
$stmt->execute([$user_id,$item_id]);
if($stmt->fetch()){
    $pdo->prepare("DELETE FROM favorites WHERE user_id=? AND item_id=?")->execute([$user_id,$item_id]);
    echo json_encode(['status'=>'removed']);
} else {
    $stmtItem = $pdo->prepare("SELECT name, description, image, price FROM shop_items WHERE itemid=?");
    $stmtItem->execute([$item_id]);
    $item = $stmtItem->fetch(PDO::FETCH_ASSOC);
    $pdo->prepare("INSERT INTO favorites(user_id,item_id,name,description,image,price) VALUES(?,?,?,?,?,?)")
        ->execute([$user_id,$item_id,$item['name'],$item['description'],$item['image'],$item['price']]);
    echo json_encode(['status'=>'added']);
}
