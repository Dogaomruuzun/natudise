<?php
require 'config.php';
session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access!";
    header("Location: admin.php");
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);


    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

   
    if ($image && $image !== 'default.jpg') { 
        $image_path = "images/" . $image;
        if (file_exists($image_path)) {
            unlink($image_path); 
        }
    }

   
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting product: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid product ID.";
}


header("Location: admin.php");
exit;
?>
