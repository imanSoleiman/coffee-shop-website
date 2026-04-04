<?php
include("../connection.php");

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php"); // adjust path
    exit;
}

$selectedCategory = $_GET['category'] ?? 'all';

$stmtCat = $pdo->query("SELECT id, namecat FROM maincategories ORDER BY namecat ASC");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

$sql = "
    SELECT si.itemid, si.name, si.price, si.image, 
           mc.namecat AS category, sc.namsub AS subcategory
    FROM shop_items si
    LEFT JOIN maincategories mc ON si.categoryid = mc.id
    LEFT JOIN subcategories sc ON si.subcategoryid = sc.id
";

$params = [];
if ($selectedCategory != 'all') {
    $sql .= " WHERE si.categoryid = :catid";
    $params[':catid'] = $selectedCategory;
}

$sql .= " ORDER BY si.itemid DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle delete
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items - Admin</title>
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
            padding: 15px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
        }

        main {
            flex: 1;
            padding: 30px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .top-bar select {
            padding: 10px 14px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s;
        }

        .top-bar select:focus {
            border-color: #ff6d48;
            box-shadow: 0 0 5px rgba(255, 126, 95, 0.3);
        }

        .add-item-link {
            background-color: #fd6742;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .add-item-link:hover {
            background-color: #ff6a45;
            transform: translateY(-2px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        table thead {
            background-color: #0766AD;
            color: #fff;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .delete-btn {
            background-color: #fa643e;
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

        @media(max-width: 600px) {

            table th,
            table td {
                font-size: 12px;
                padding: 8px 10px;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <header>
        <h2>View Items</h2>
    </header>

    <main>
        <div class="top-bar">
            <select onchange="window.location='?category='+this.value">
                <option value="all" <?= $selectedCategory == 'all' ? 'selected' : '' ?>>All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['namecat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a href="add_item.php" class="add-item-link">+ Add Item</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><img class="item-image" src="../image/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= htmlspecialchars($item['subcategory']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <a href="?delete=<?= $item['itemid'] ?>" onclick="return confirm('Are you sure?')">
                                    <button class="delete-btn">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>

</html>