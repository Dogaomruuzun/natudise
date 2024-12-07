
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
    <p style="font-size: 30px;"><strong>NATUDISE</strong></p>
    <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#products">Products</a>
        <a href="#review">Review</a>
        <a href="#contact">Contact</a>
        
        <a href="orders.php" class="order-icon" style="margin-left: 20px;">
    <img src="images/order-icon.png" alt="Orders Icon" style="width: 33px; height: 33px;">
        </a>

        <a href="admin.php" class="admin-icon" style="margin-left: 20px;">
            <img src="images/admin-icon.png" alt="Admin Icon" style="width: 33px; height: 33px;">
        </a>
        
    </nav>
</header>
<section class="home" id="home">
    <div class="content">
        <h3>Handcrafted Treasures</h3>
        <span>Natural Inspired Designs</span>
        <p style="font-size: 23px;">Welcome to Natudise, where creativity meets craftsmanship! Established two years ago, we are proud to offer a stunning selection of handcrafted treasures, each piece unique and made with love.
            Our talented artisans pour their heart and soul into every item, ensuring that you receive nothing but the best. Don't miss out on our exquisite products—shop now and discover the perfect addition to your collection before they sell out!</p>
        <a href="#products" class="btn"> Shop Now</a>
    </div>
</section>


<section class="about" id="about">
    <div class="row">
        <div class="content">
            <h3>WHY CHOOSE US?</h3>
            <p style="font-size: 23px;">Each of our products is lovingly and meticulously handcrafted to ensure uniqueness and exceptional quality.
                Our creations are not only visually appealing but also durable and practical, making them the perfect addition to your daily life or a thoughtful gift for your loved ones.
                By choosing us, you support local craftsmanship and sustainable practices, as we prioritize eco-friendly materials. Every piece tells its own story, designed to bring a touch of individuality and charm to your life.
                If you're looking for meaningful, handmade products that stand out, you've come to the right place!</p>
            <a href="#home" class="btn">Learn More</a>
        </div>
    </div>
</section>


<section class="details-container">
    <div class="details">
        <div class="info">
            <h3 style="color:darkblue;">Free delivery</h3>
            <span>on all orders</span>
        </div>
    </div>

    <div class="details">
        <div class="info">
            <h3 style="color:darkblue;">10 days returns</h3>
            <span>Moneyback guarantee</span>
        </div>
    </div>

    <div class="details">
        <div class="info">
            <h3 style="color:darkblue;">Offer & gits</h3>
            <span>on all orders</span>
        </div>
    </div>

    <div class="details">
        <div class="info">
            <h3 style="color:darkblue;">Secure paymens</h3>
            <span>protected by paypal</span>
        </div>
    </div>
</section>

<section class="categories">
    <h1 class="heading">Browse by <span>Category</span></h1>
    <div class="category-container">
        <a href="?category=Keychains" class="btn">Keychains</a>
        <a href="?category=Wristbands" class="btn">Wristbands</a>
        <a href="?category=Necklaces" class="btn">Necklaces</a>
        <a href="?category=Hats" class="btn">Hats</a>
        <a href="?category=Scarfs" class="btn">Scarfs</a>
        <a href="?category=Bags" class="btn">Bags</a>
        <a href="?category=Clothes" class="btn">Clothes</a>
        <a href="home.php#products" class="btn">All Products</a>
    </div>
</section>


<section class="products" id="products">
    <h1 class="heading">Latest <span>Products</span></h1>
    <div class="box-container">
        <?php
        require 'config.php';

        $category = isset($_GET['category']) ? $_GET['category'] : '';
       
       
        if ($category) {
            $sql = "SELECT * FROM products WHERE category = '$category'";
        } else {
            $sql = "SELECT * FROM products"; 
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="box">';
                echo '<span class="discount">-' . $row['discount_percentage'] . '%</span>';
                echo '<div class="image">';
                echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<br>';
                echo '<form action="cart.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<input type="hidden" name="product_name" value="' . $row['name'] . '">';
                echo '<input type="hidden" name="product_price" value="' . $row['price'] . '">';
                echo '<button type="submit" name="add_to_cart" class="btn">Add to Cart</button>';
                echo '</form>';
                echo '</div>';
                echo '<div class="content">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<div class="price">$' . $row['price'] . ' <span>$' . ($row['price'] * (1 + $row['discount_percentage'] / 100)) . '</span></div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No products available in this category</p>';
        }
        ?>
    </div>
</section>

<section class="review" id="review">
    <h1 class="heading">Customer's <span>Review</span></h1>
    <div class="box-container">
        <div class="box">
            <p>
                <strong>Taylor Swift</strong> ⭐⭐⭐⭐⭐<em> - The wool gloves I ordered are fantastic! They’re not only warm but also so comfortable to wear. You can feel the love and effort that went into making them. The delivery was quick, and the packaging was so charming. I’m a happy customer and will be back for more!
            </em></p>
            <div class="user">
                <img src="images/taylorswift.jpg" alt="Taylor Swift">
                <div class="user-info">
                    <h3>Taylor Swift</h3>
                    <span>Happy Customers</span>
                </div>
            </div>
        </div>

        <div class="box">
            <p>
                <strong>Selena Gomez</strong> ⭐⭐⭐⭐⭐<em>- I purchased a hand-knitted wool hat, and it's honestly the best winter accessory I own. It's stylish, warm, and fits perfectly. Plus, the vibrant colors are just stunning! I've received so many compliments, and I've recommended your shop to all my friends.
            </em></p>
            <div class="user">
                <img src="images/selena.jpg" alt="Selena Gomez">
                <div class="user-info">
                    <h3>Selena Gomez</h3>
                    <span>Happy Customers</span>
                </div>
            </div>
        </div>

        <div class="box">
            <p>
                <strong>Leonardo Dicaprio</strong> ⭐⭐⭐⭐⭐<em>- These wool products are amazing! I bought a blanket, and it's become my go-to for cozy evenings on the couch. The craftsmanship is top-notch, and it feels great supporting a small business with such passion for their work. Can't wait to buy more!
            </em></p>
            <div class="user">
                <img src="images/leonardo.jpg" alt="Leonardo Dicaprio">
                <div class="user-info">
                    <h3>Leonardo Dicaprio</h3>
                    <span>Happy Customers</span>
                </div>
            </div>
        </div>

        <div class="box">
            <p><strong>Tobey Maguire</strong> ⭐⭐⭐⭐⭐<em> -I absolutely love the quality of the handmade wool products! The texture is so soft, and you can tell it's made with care and attention to detail. I've already purchased a scarf and a pair of mittens, and they keep me so warm during the chilly days. Highly recommend these beautiful, handcrafted items!
            </em></p>
            <div class="user">
                <img src="images/tobey.jpg" alt="Tobey Maguire">
                <div class="user-info">
                    <h3>Tobey Maguire</h3>
                    <span>Happy Customers</span>
                </div>
            </div>
        </div>
 </div>
</section>


<section class="contact" id="contact">
    <h1 class="heading"><span> CONTACT </span> US </h1>
    <div class="row">
        <form action="">
            <input type="text" class="box" placeholder="Name">
            <input type="email" class="box" placeholder="Email">
            <input type="number" class="box" placeholder="Number">
            <textarea name="" class="box" placeholder="Message" cols="30" rows="10"></textarea>
            <a href="#home" class="btn">Send Massage</a>
        </form>
    </div>
</section>


<section class="footer">
    <div class="box-container">

        <div class="box">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#review">Review</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>

        <div class="box">
            <h3>Extra Links</h3>
            <a href="#products" style="color:yellowgreen; font-weight: bold;">Our Favorites</a>

        </div>

        <div class="box">
            <h3>Locations</h3>
             <pre style="color: aquamarine">Turkey   Germany   Japan  Ukraine</pre>
        </div>

        <div class="box">
            <h3>Contact Information</h3>
            <p style="color:pink">+90 (532) 32 32</p>
            <p style="color:pink">natudise@gmail.com</p>
            <p style="color:pink">Türkiye,Ankara</p>
        </div>
    </div>

    <div class="credit">
        &copy; Created by <span>Doğa Ömrüuzun and İrem Sena Alpak</span>

        <div class="social-icons">
            <a href="https://www.instagram.com/yourusername" target="_blank">
                <img src="images/instagram.png" style="width: 24px;" alt="" />
            </a>
            <a href="https://www.facebook.com/yourusername" target="_blank">
                <img src="images/facebook.png" style="width: 24px;" alt=""/>
            </a>
            <a href="https://www.twitter.com/yourusername" target="_blank">
                <img src="images/twitter.png" style="width: 24px;" alt=""/>
            </a>
        </div>
    </div>
</section>
</body>
</html>