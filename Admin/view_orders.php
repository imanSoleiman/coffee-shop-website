<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php");
    exit;
}


$stmt = $pdo->prepare("
    SELECT o.id AS order_id, u.name AS customer_name, u.email, 
           i.name AS item_name, o.quantity, o.total_price
    FROM orders o
    JOIN users u ON o.user_id = u.userid
    JOIN shop_items i ON o.item_id = i.itemid
    ORDER BY o.id DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("view_orders.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Admin</title>
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
            padding: 15px 20px;
            display: flex;
            align-items: center;
            position: relative;
        }

        header h2 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 22px;
        }

        .back-btn {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
        }

        .back-btn:hover {
            color: #FF7E5F;
        }

        main {
            flex: 1;
            padding: 30px;
        }

        h1 {
            color: #0766AD;
            margin-bottom: 20px;
            text-align: center;
            font-size: 28px;
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

        .delete-btn {
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

        .view-btn {
            background-color: #FF7E5F;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .view-btn:hover {
            opacity: 0.9;
        }

        @media(max-width: 600px) {

            table th,
            table td {
                font-size: 12px;
                padding: 8px 10px;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="back-btn">&#8592; Back</a>
        <h2>View Orders</h2>
    </header>

    <main>
        <h1>Orders</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($orders) === 0): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                            <td><?= htmlspecialchars($order['item_name']) ?></td>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                          
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script>
        // Optional: Add JS for delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const orderId = btn.dataset.id;
                if (confirm('Are you sure you want to delete order #' + orderId + '?')) {
                    fetch('delete_order.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: orderId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                btn.closest('tr').remove();
                            } else {
                                alert('Error deleting order: ' + data.message);
                            }
                        });
                }
            });
        });
    </script>

</body>

</html>