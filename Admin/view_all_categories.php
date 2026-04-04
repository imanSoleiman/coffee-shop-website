<?php
include("../connection.php");

session_start();

// If not logged in or not admin, redirect to login or home page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}


$stmt = $pdo->query("SELECT id, namecat, image FROM maincategories ORDER BY namecat ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Categories - Admin</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #0766AD;
            color: #fff;
            padding: 20px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .back-btn {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
            z-index: 2;
        }

        .back-btn:hover {
            background-color: #FF7E5F;
        }

        header h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            margin: 0;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: #FF7E5F;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
        }

        .add-btn:hover {
            background-color: #ff6a45;
            transform: translateY(-2px);
        }

        /* Categories grid like dashboard cards */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .category-card {
            background-color: #fff;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .category-card img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            margin-bottom: 12px;
        }

        .category-card h3 {
            margin-bottom: 10px;
            color: #0766AD;
            font-size: 18px;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fa643eff;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .delete-btn:hover {
            opacity: 0.9;
        }

        @media(max-width:600px) {
            header h1 {
                font-size: 20px;
            }

            .categories-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="back-btn">&#8592; Back to Dashboard</a>
        <h1>View All Categories</h1>
    </header>

    <main>
        <div class="top-bar">
            <a href="add_Categories.php" class="add-btn">+ Add New Category</a>
        </div>

        <div class="categories-grid">
            <?php if (count($categories) > 0): ?>
                <?php foreach ($categories as $cat): ?>
                    <div class="category-card">
                        <img src="../image/<?= htmlspecialchars($cat['image']) ?>"
                            alt="<?= htmlspecialchars($cat['namecat']) ?>">

                        <h3><?= htmlspecialchars($cat['namecat']) ?></h3>

                        <form method="POST" action="delete_category.php"
                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </div>

    </main>

</body>

</html>