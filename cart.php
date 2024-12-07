<?php
session_start();

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (isset($_POST['add_to_cart'])) {
        $product = [
            'id' => $_POST['product_id'],
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'quantity' => 1
        ];

       
        if (isset($_SESSION['cart'])) {
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $product['id']) {
                    $item['quantity'] += 1;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['cart'][] = $product;
            }
        } else {
            $_SESSION['cart'][] = $product;
        }

        
        header("Location: cart.php");
        exit();
    }

    
    if (isset($_POST['remove_item'])) {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] == $product_id) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }

            
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        header("Location: cart.php");
        exit();
    }

    
    if (isset($_POST['clear_cart'])) {
        unset($_SESSION['cart']);
        header("Location: home.php");
        exit();
    }

    if (isset($_POST['checkout'])) {
        require 'config.php';
    
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $product_id = $item['id'];
                $product_name = $item['name'];
                $product_price = $item['price'];
                $quantity = $item['quantity'];
                $total_price = $product_price * $quantity;
    
    
                $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, product_name, product_price, quantity, total_price, order_date, status) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
                
                $user_id = $_SESSION['user_id'] ?? null; 
                $status = 'pending'; 
    
                $stmt->bind_param("iisdiis", $user_id, $product_id, $product_name, $product_price, $quantity, $total_price, $status);
    
                if (!$stmt->execute()) {
                    error_log("Sipariş kaydedilemedi: " . $stmt->error);
                }
            }
        }
    
      
        unset($_SESSION['cart']);
        $_SESSION['message'] = "Your order has been successfully registered! Thank you.";
        if (isset($_SESSION['message'])) {
 
            echo "<p style='color: green; text-align: center; font-size: 20px;'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
         
            header("Refresh:3; url=home.php#home");
            exit();
        }
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
    
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: center;
            font-size: 18px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

      
        button, a {
            display: inline-block;
            margin: 15px 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover, a:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
        }

       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
        }

        h1 {
            margin: 20px 0;
        }

     
        .total {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Shopping Cart</h1>

    <?php 
    $total = 0; 
    if (!empty($_SESSION['cart'])): 
    ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <?php 
                        $item_total = $item['price'] * $item['quantity']; 
                        $total += $item_total; 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= htmlspecialchars($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>$<?= number_format($item_total, 2) ?></td>
                        <td>
                            <form action="cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <button type="submit" name="remove_item">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        
        <div class="total">
            Total Amount: $<?= number_format($total, 2) ?>
        </div>

        <form action="cart.php" method="POST" style="margin-top: 20px;">
            <button type="submit" name="clear_cart">Clear Cart</button>
            <button type="submit" name="checkout">Checkout</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>

   
    <a href="home.php#products" class="btn">Back to Products</a>
</body>
</html>
