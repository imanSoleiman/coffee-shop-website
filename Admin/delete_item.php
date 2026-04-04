<?php
include("../connection.php");
if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete'];

    // Delete image file
    $stmtImg = $pdo->prepare("SELECT image FROM shop_items WHERE itemid = :id");
    $stmtImg->execute([':id' => $idToDelete]);
    $imgRow = $stmtImg->fetch(PDO::FETCH_ASSOC);
    if ($imgRow && file_exists('../image/' . $imgRow['image'])) {
        unlink('../image/' . $imgRow['image']);
    }

    // Delete from database
    $stmtDel = $pdo->prepare("DELETE FROM shop_items WHERE itemid = :id");
    $stmtDel->execute([':id' => $idToDelete]);

    header("Location: view_items.php");
    exit;
}
