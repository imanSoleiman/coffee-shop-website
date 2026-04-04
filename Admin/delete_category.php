
<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id']; // cast to int for safety

    // Optional: delete the category image file
    $stmt = $pdo->prepare("SELECT image FROM maincategories WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($category && !empty($category['image'])) {
        $imagePath = __DIR__ . "/../image/" . $category['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete the image file
        }
    }
    $stmt = $pdo->prepare("DELETE FROM maincategories WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        header("Location: view_all_categories.php"); // redirect back to categories page
        exit;
    } else {
        echo "Error deleting category.";
    }
} else {
    echo "Invalid request.";
}
