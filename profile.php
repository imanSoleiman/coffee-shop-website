<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER DATA */
$stmt = $pdo->prepare("SELECT name, email, profile_image FROM users WHERE userid = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$name  = $user['name'] ?? '';
$email = $user['email'] ?? '';
$image = !empty($user['profile_image']) ? $user['profile_image'] : "default.png";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            margin-top: 100px;
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 60px 20px;
        }

        .profile-container {
            max-width: 420px;
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .profile-header {
            background: #f8f6f2;
            color: #0766AD;
            padding: 50px 20px 20px;
            text-align: center;
            clip-path: ellipse(100% 85% at 50% 0%);
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile-menu {
            display: flex;
            flex-direction: column;
        }

        .menu-item {
            padding: 18px 25px;
            display: flex;
            gap: 16px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .menu-item:hover {
            background: #f9f9f9;
        }

        .menu-item img {
            width: 24px;
        }

        .menu-item a {
            text-decoration: none;
            color: #333;
            flex: 1;
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 22px;
            cursor: pointer;
        }

        .modal-content input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
        }

        .modal-content button {
            width: 100%;
            padding: 12px;
            background: #0766AD;
            color: #fff;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body>

    <?php include "header.php"; ?>

    <div class="content-wrapper">
        <div class="profile-container">
            <div class="profile-header">
                <img src="image/<?php echo htmlspecialchars($image); ?>">
                <h2><?php echo htmlspecialchars($name); ?></h2>
                <p><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div class="profile-menu">
                <div class="menu-item" onclick="openEdit()">
                    <img src="https://img.icons8.com/ios-filled/50/user.png">
                    <span>Profile</span>
                </div>

                <div class="menu-item">
                    <img src="./images/heart (2).png">
                    <a href="favorite.php">favorites</a>
                </div>

                <div class="menu-item" onclick="openLogout()">
                    <img src="https://img.icons8.com/ios-filled/50/logout-rounded-left.png">
                    <span>Logout</span>
                </div>
            </div>

        </div>
    </div>

    <!-- EDIT PROFILE -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeEdit()">&times;</span>
            <h3>Edit Profile</h3>

            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <input type="file" name="profile_image" accept="image/*">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- LOGOUT -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeLogout()">&times;</span>
            <h3>Logout?</h3>
            <button onclick="location.href='logout.php'" style="background:#ff4d4f">Yes, Logout</button>
            <button onclick="closeLogout()">Cancel</button>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script>
        function openEdit() {
            editModal.style.display = 'flex'
        }

        function closeEdit() {
            editModal.style.display = 'none'
        }

        function openLogout() {
            logoutModal.style.display = 'flex'
        }

        function closeLogout() {
            logoutModal.style.display = 'none'
        }
        window.onclick = e => {
            if (e.target.classList.contains('modal')) e.target.style.display = 'none'
        }
    </script>

</body>

</html>