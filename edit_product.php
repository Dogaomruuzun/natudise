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

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if (!$product) {
        $_SESSION['error'] = "Product not found!";
        header("Location: admin.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
    header("Location: admin.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $discount = intval($_POST['discount']);

   
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, discount_percentage = ? WHERE id = ?");
    $stmt->bind_param("ssdii", $name, $description, $price, $discount, $product_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating product: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
        }

        .btn.secondary {
            background-color: #6c757d;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn.secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>

       
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

       
        <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="discount">Discount (%)</label>
                <input type="number" id="discount" name="discount" value="<?php echo htmlspecialchars($product['discount_percentage']); ?>">
            </div>
            <button type="submit" class="btn">Update Product</button>
            <a href="admin.php" class="btn secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
