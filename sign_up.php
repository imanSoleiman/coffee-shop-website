<?php
session_start();
include 'connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($firstName  && $email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:first, :email, :pass)");
            $stmt->execute([
                ':first' => $firstName,
                ':email' => $email,
                ':pass' => $hashedPassword
            ]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $firstName . ' ' . $lastName;
            header("Location: profile.php");
            exit;
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
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
            width: 100%;
            max-width: 400px;
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
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: 0.3s;
            outline: none;
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
            <h2>Create Account</h2>
            <?php if ($error) echo '<div class="error">' . $error . '</div>'; ?>
            <form method="POST">
                <input type="text" name="first_name" placeholder=" Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>
            <div class="toggle">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>

</body>

</html>