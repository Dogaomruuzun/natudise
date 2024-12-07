<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NATUDISE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>NATUDISE</h1>
</header>

<section class="products" id="products">
    <h1 class="heading">Latest <span>Products</span></h1>
    
  
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="admin.php" class="btn" style="margin: 20px; padding: 10px; display: inline-block; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">+ Add Product</a>
    <?php endif; ?>
    
    <div class="box-container">
        
        <?php
        require 'config.php'; 
        $query = "SELECT * FROM products";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0):
            while ($product = $result->fetch_assoc()): ?>
                <div class="box">
                    <div class="image">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="content">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="price">$<?php echo htmlspecialchars($product['price']); ?> 
                            <?php if (!empty($product['discount'])): ?>
                                <span>$<?php echo number_format($product['price'] * (1 + $product['discount'] / 100), 2); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <p>No products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>
