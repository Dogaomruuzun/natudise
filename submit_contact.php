<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['number']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, number, message) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssss", $name, $email, $number, $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }
    } else {
        $_SESSION['error'] = "Please fill in all required fields.";
    }

    header("Location: home.php");
    exit;
}
?>
