<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "natudise";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error); 
    die("Database connection problem. Please try again later.");
}


$conn->set_charset("utf8mb4");


function loginUser($email, $password) {
    global $conn;

   
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error); 
        return false;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false; 
    }

    $user = $result->fetch_assoc();


    if ($user && password_verify($password, $user['password'])) {
        session_start(); 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        return true; 
    }

    return false; 
}


function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

?>
