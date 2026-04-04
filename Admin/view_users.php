<?php
session_start();
include '../connection.php';

// Make sure the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Fetch users and their total orders
$stmt = $pdo->prepare("
    SELECT u.userid, u.name, u.email, 
           COUNT(o.id) AS total_orders
    FROM users u
    LEFT JOIN orders o ON u.userid = o.user_id
    GROUP BY u.userid
    ORDER BY u.name ASC
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users - Admin</title>
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
        <h2>View Users</h2>
    </header>

    <main>
        <h1>Registered Users</h1>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) === 0): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['total_orders'] ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.dataset.id;
                if (confirm('Are you sure you want to delete this user?')) {
                    fetch('delete_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: userId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                btn.closest('tr').remove();
                            } else {
                                alert('Error deleting user: ' + data.message);
                            }
                        });
                }
            });
        });
    </script>

</body>

</html>