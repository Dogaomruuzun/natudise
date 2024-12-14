<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); 
    $email = trim($_POST['email']); 
    $password = $_POST['password']; 

    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        header("Location: register.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email is already registered.";
        header("Location: register.php");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful. You can now login.";
        header("Location: login.html"); 
        exit;
    } else {
        $_SESSION['error'] = "An error occurred during registration. Please try again.";
        header("Location: register.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body.register-page {
            font-family: "Georgia", serif;
            background-color: #fef3e6;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            text-align: center;
            border: 1px solid #e0dcdc;
        }
        .register-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #b85c38;
            font-family: "Cursive", serif;
        }
        .register-container label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
            display: block;
            text-align: left;
            margin-top: 10px;
        }
        .register-container input {
            padding: 12px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fdfdfd;
            box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.05);
            width: 100%;
            box-sizing: border-box;
        }
        .register-container input:focus {
            border-color: #b85c38;
            outline: none;
            box-shadow: 0px 0px 5px rgba(184, 92, 56, 0.5);
        }
        .register-container button {
            padding: 12px;
            background-color: #b85c38;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .register-container button:hover {
            background-color: #a24e2f;
            transform: translateY(-3px);
        }
        .message {
            margin-top: 10px;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body class="register-page">
    <div class="register-container">
        <h1>Create an Account</h1>
        <form action="register.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit">Sign Up</button>
        </form>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
    </div>
</body>
</html>
