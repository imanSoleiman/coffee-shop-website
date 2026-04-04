<?php
session_start();
include '../connection.php';

// Check admin login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Fetch counts
$userCountStmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
$totalUsers = $userCountStmt->fetch(PDO::FETCH_ASSOC)['total_users'];

$orderCountStmt = $pdo->query("SELECT COUNT(*) as total_orders FROM orders");
$totalOrders = $orderCountStmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

$itemCountStmt = $pdo->query("SELECT COUNT(*) as total_items FROM shop_items");
$totalItems = $itemCountStmt->fetch(PDO::FETCH_ASSOC)['total_items'];

$categoryCountStmt = $pdo->query("SELECT COUNT(*) as total_categories FROM maincategories");
$totalCategories = $categoryCountStmt->fetch(PDO::FETCH_ASSOC)['total_categories'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* ... keep your existing CSS from before ... */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f8;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #0766AD;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: 30px;
            flex-shrink: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            color: #FF7E5F;
        }

        .nav-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            color: #fff;
        }

        .nav-item:hover {
            background-color: rgba(255, 126, 95, 0.2);
        }

        .nav-item img {
            width: 20px;
            height: 20px;
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 30px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 28px;
            color: #0766AD;
        }

        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #fff;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #0766AD;
        }

        .card p {
            font-size: 14px;
            color: #ee4d18ff;
            font-weight: 400;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a class="nav-item" href="view_users.php">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/user-group-man-man.png" alt="">
            View Users
        </a>
        <a class="nav-item" href="view_orders.php">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/money-bag.png" alt="">
            Orders
        </a>
        <a class="nav-item" href="./view_items.php">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/add-shopping-cart.png" alt="">
            Items
        </a>
        <a class="nav-item" href="view_all_categories.php">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/tags.png" alt="">
            Categories
        </a>
        <!-- Logout link -->
        <a class="nav-item" href="../logout.php">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/exit.png" alt="">
            Logout
        </a>
    </div>


    <div class="main-content">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Users</h3>
                <p><?= $totalUsers ?> registered users</p>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <p><?= $totalOrders ?> total orders</p>
            </div>
            <div class="card">
                <h3>Items</h3>
                <p><?= $totalItems ?> products</p>
            </div>
            <div class="card">
                <h3>Categories</h3>
                <p><?= $totalCategories ?> categories</p>
            </div>
        </div>
    </div>

</body>

</html>