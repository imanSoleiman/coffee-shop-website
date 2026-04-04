<?php
include("../connection.php");
session_start();

// If not logged in or not admin, redirect to login or home page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}


$selectedCategory = $_GET['category'] ?? $_POST['category'] ?? '';
$selectedSubcategory = $_POST['subcategory'] ?? '';
$description = $_POST['description'] ?? '';

$stmt = $pdo->query("SELECT id, namecat FROM maincategories ORDER BY namecat ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subcategories = [];
if ($selectedCategory) {
    $stmt = $pdo->prepare("SELECT id, namsub FROM subcategories WHERE mainid = :mainid ORDER BY namsub ASC");
    $stmt->execute([':mainid' => $selectedCategory]);
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (isset($_POST['submit'])) {
    $name = $_POST['itemName'];
    $price = $_POST['price'];
    $categoryId = $_POST['category'];
    $subCategoryId = !empty($_POST['subcategory']) ? $_POST['subcategory'] : null;
    $description = $_POST['description'];

    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] == 0) {
        $imgName = time() . '_' . $_FILES['itemImage']['name'];
        $imgTmp = $_FILES['itemImage']['tmp_name'];
        $imgPath = '../image/' . $imgName;

        if (move_uploaded_file($imgTmp, $imgPath)) {
            $stmt = $pdo->prepare("
                INSERT INTO shop_items 
                (name, price, categoryid, subcategoryid, description, image) 
                VALUES 
                (:name, :price, :category, :subcategory, :description, :image)
            ");
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':category' => $categoryId,
                ':subcategory' => $subCategoryId,
                ':description' => $description,
                ':image' => $imgName
            ]);

            echo "<script>alert('Item added successfully!'); window.location.href='view_items.php';</script>";
            exit;
        } else {
            $error = "Failed to upload image";
        }
    } else {
        $error = "Please upload an image";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #0766AD;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header h2 {
            margin: 0;
            font-size: 22px;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        header a:hover {
            color: #FF7E5F;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .add-item-container {
            background: #fff;
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 450px;
        }

        .add-item-container h2 {
            color: #0766AD;
            margin-bottom: 25px;
            font-size: 28px;
            text-align: center;
        }

        .add-item-container label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .add-item-container input[type="text"],
        .add-item-container input[type="number"],
        .add-item-container input[type="file"],
        .add-item-container select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .add-item-container input:focus,
        .add-item-container select:focus {
            border-color: #FF7E5F;
            box-shadow: 0 0 5px rgba(255, 126, 95, 0.4);
        }

        .add-item-container button {
            width: 100%;
            padding: 14px 0;
            margin-top: 25px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #FF7E5F;
            cursor: pointer;
            transition: 0.3s;
        }

        .add-item-container button:hover {
            background-color: #ff6a45;
            transform: translateY(-2px);
        }

        /* Image preview */
        .image-preview {
            margin-top: 10px;
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
            display: none;
            border: 2px solid #0766AD;
        }
    </style>
</head>

<body>

    <header>
        <a href="view_items.php">&#8592;</a>
        <h2>Add New Item</h2>
    </header>

    <main>
        <form class="add-item-container" method="POST" enctype="multipart/form-data">
            <h2>Add New Item</h2>

            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <label for="itemName">Item Name</label>
            <input type="text" name="itemName" id="itemName" placeholder="Enter item name" required>

            <label for="price">Price ($)</label>
            <input type="number" name="price" id="price" placeholder="Enter price" required>

            <label for="category">Category</label>
            <select name="category" id="category" onchange="window.location='?category='+this.value" required>
                <option value="">Select category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $selectedCategory) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['namecat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="subcategory">Subcategory</label>
            <select name="subcategory" id="subcategory">
                <option value="">Select subcategory</option>
                <?php foreach ($subcategories as $sub): ?>
                    <option value="<?= $sub['id'] ?>" <?= ($sub['id'] == $selectedSubcategory) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sub['namsub']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter item description" required><?= htmlspecialchars($description) ?></textarea>

            <label for="itemImage">Upload Image</label>
            <input type="file" name="itemImage" id="itemImage" accept="image/*" required>

            <button type="submit" name="submit">Add Item</button>
        </form>


    </main>

    <script>
    </script>

</body>

</html>