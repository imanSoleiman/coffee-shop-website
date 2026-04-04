<?php
session_start();
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        if ($email === 'admin@gmail.com' && $password === 'admin123') {
            $_SESSION['user_id'] = 0;
            $_SESSION['user_name'] = 'Admin';
            $_SESSION['is_admin'] = true;
            header("Location: admin/index.php");
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['userid'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = false;
            header("Location: profile.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please enter email and password.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles from login.php */
        body {
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            padding-top: 100px;
        }

        .auth-container {
            background: #fff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .auth-container h2 {
            margin-bottom: 25px;
            font-size: 28px;
            color: #0766AD;
            font-weight: 700;
        }

        .auth-container input {
            width: 100%;
            padding: 14px 15px;
            margin: 12px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        .auth-container input:focus {
            border-color: #FF7E5F;
            box-shadow: 0 0 5px rgba(255, 126, 95, 0.4);
        }

        .auth-container button {
            width: 100%;
            padding: 16px 0;
            margin-top: 15px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #fd633dff;
            cursor: pointer;
            transition: 0.3s;
        }

        .auth-container button:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .auth-container .toggle {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .auth-container .toggle a {
            color: #0766AD;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: 0.3s;
        }

        .auth-container .toggle a:hover {
            color: #FF7E5F;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <main>
        <div class="auth-container">
            <h2>Login</h2>
            <?php if ($error) echo '<div class="error">' . $error . '</div>'; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <div class="toggle">
                Don't have an account? <a href="sign_up.php">Sign Up</a>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>
</body>

</html>