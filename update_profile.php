<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$name    = trim($_POST['name']);
$email   = trim($_POST['email']);

/* GET CURRENT IMAGE */
$stmt = $pdo->prepare("SELECT profile_image FROM users WHERE userid = ?");
$stmt->execute([$user_id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);
$profile_image = $current['profile_image'];

/* IMAGE UPLOAD */
if (!empty($_FILES['profile_image']['name'])) {

    $folder = "image/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp'];

    if (in_array(strtolower($ext), $allowed)) {

        $newName = "user_" . $user_id . "_" . time() . "." . $ext;
        $path = $folder . $newName;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $path)) {
            $profile_image = $newName;
        }
    }
}

/* UPDATE USER */
$update = $pdo->prepare("
    UPDATE users 
    SET name = ?, email = ?, profile_image = ?
    WHERE userid = ?
");
$update->execute([$name, $email, $profile_image, $user_id]);

header("Location: profile.php");
exit;
