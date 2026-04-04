<?php
include("../connection.php");
session_start();

// If not logged in or not admin, redirect to login or home page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}

$message = "";
$message_type = "";
$sub_message = "";

$uploadDir = __DIR__ . "/../image/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_POST['add_main_category'])) {

    $namecat = trim($_POST['categoryName'] ?? '');

    if (empty($namecat)) {
        $message = "Category name is required.";
        $message_type = "error";
    } elseif (!isset($_FILES['categoryImage']) || $_FILES['categoryImage']['error'] !== UPLOAD_ERR_OK) {
        $message = "Please upload a valid image.";
        $message_type = "error";
    } else {
        $ext = pathinfo($_FILES['categoryImage']['name'], PATHINFO_EXTENSION);
        $imageName = "category_" . time() . "." . $ext;
        $targetFile = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['categoryImage']['tmp_name'], $targetFile)) {
            $stmt = $pdo->prepare(
                "INSERT INTO maincategories (namecat, image)
                 VALUES (:namecat, :image)"
            );
            $stmt->execute([
                ':namecat' => $namecat,
                ':image' => $imageName
            ]);

            header("Location: add_Categories.php?success=main");
            exit;
        } else {
            $message = "Image upload failed.";
            $message_type = "error";
        }
    }
}

if (isset($_POST['add_sub_category'])) {

    $namsub = trim($_POST['subCategoryName'] ?? '');
    $mainid = $_POST['parentCategory'] ?? '';

    if (empty($namsub) || empty($mainid)) {
        $sub_message = "Please select a parent category and enter subcategory name.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO subcategories (namsub, mainid)
             VALUES (:namsub, :mainid)"
        );
        $stmt->execute([
            ':namsub' => $namsub,
            ':mainid' => $mainid
        ]);
        header("Location: add_Categories.php?success=sub");
        exit;
    }
}

$stmt = $pdo->query("SELECT id, namecat FROM maincategories ORDER BY namecat ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6f8;
        }

        header {
            background: #0766AD;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        main {
            padding: 40px 20px;
        }

        .forms-wrapper {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .form-box {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h3 {
            margin-bottom: 15px;
            color: #0766AD;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
            background: #FF7E5F;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #ff6a45;
        }

        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <header>Add Categories</header>

    <main>
        <div class="forms-wrapper">

            <form method="POST" enctype="multipart/form-data" class="form-box">
                <?php if (isset($_GET['success']) && $_GET['success'] === 'main'): ?>
                    <div class="message success">
                        Main category added successfully!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="message error">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>


                <h3>Main Category</h3>

                <label>Category Name</label>
                <input type="text" name="categoryName" required>

                <label>Category Image</label>
                <input type="file" name="categoryImage" accept="image/*" required>

                <button type="submit" name="add_main_category">
                    Add Category
                </button>
            </form>
            <form method="POST" class="form-box">
                <?php if (isset($_GET['success']) && $_GET['success'] === 'sub'): ?>
                    <div class="message success">
                        Subcategory added successfully!
                    </div>
                <?php endif; ?>


                <h3>Sub Category</h3>

                <label>Main Category</label>
                <select name="parentCategory" required>
                    <option value="">Select category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars($cat['namecat']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Subcategory Name</label>
                <input type="text" name="subCategoryName" required>

                <button type="submit" name="add_sub_category">
                    Add Sub Category
                </button>
            </form>

        </div>
    </main>

</body>

</html>