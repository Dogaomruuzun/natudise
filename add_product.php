<?php
require 'config.php';
session_start();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: admin.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $discount = isset($_POST['discount']) ? intval($_POST['discount']) : 0;
    $image = ''; 

    
    if ($price <= 0) {
        $price = 0.01;
    }
    if ($discount < 0 || $discount > 100) {
        $discount = 0; 
    }

  
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = $_FILES['image']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($image_name);

      
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $image_name; 
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, discount_percentage, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdss", $name, $description, $price, $discount, $image);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product added successfully!";
    } else {
        $_SESSION['error'] = "Error adding product: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin.php");
    exit;
}
?>
