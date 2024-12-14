# NATUDISE e-commerce
===========================

**This project developed by Doğa ÖMRÜUZUN and İrem Sena ALPAK.**

**Web Design and Programming CENG 361**

---

## Features

### User Features:
1. **Product Browsing:**
   - Explore categories like Keychains, Wristbands, Necklaces, Hats, Scarves, Bags, and Clothes.
   - View all available products with detailed descriptions, prices, and discount offers.

2. **Shopping Cart:**
   - Add products to your cart and view total prices.
   - Remove items or proceed to checkout.

3. **Order Management:**
   - Place orders and track order history via the `My Orders` page.
   - View details like order ID, product name, quantity, price, and status.

4. **Secure Payments:**
   - Pay securely through integrated payment methods like PayPal.

5. **Customer Reviews:**
   - Read customer reviews from happy clients who appreciate the craftsmanship.

6. **Contact Form:**
   - Reach out to us for inquiries or support via the `Contact Us` section.

### Admin Features:
1. **Admin Dashboard:**
   - Manage product inventory (add, edit, and delete products).
   - Oversee customer orders and update their statuses.

2. **User Management:**
   - View and manage registered users.

3. **Analytics:**
   - Track website performance and product popularity.

---

## Technology Stack

- **Frontend:**
  - HTML5, CSS3
  - JavaScript for interactivity

- **Backend:**
  - PHP for server-side logic

- **Database:**
  - MySQL for data storage (e.g., products, users, orders)

---

## Welcome to NATUDISE

Welcome to **NATUDISE**, where creativity meets craftsmanship! Established two years ago, we are proud to offer a stunning selection of handcrafted treasures, each piece unique and made with love. Our talented artisans pour their heart and soul into every item, ensuring that you receive nothing but the best. Don't miss out on our exquisite products—shop now and discover the perfect addition to your collection before they sell out!

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repository/natudise.git
   ```

2. Navigate to the project directory:
   ```bash
   cd natudise
   ```

3. Set up the database:
   - Import the provided `database.sql` file into your MySQL server.

4. Configure the database connection:
   - Update the `config.php` file with your database credentials:
     ```php
     <?php
     $servername = "localhost";
     $username = "your_username";
     $password = "your_password";
     $dbname = "natudise_db";
     ?>
     ```

5. Launch the application:
   - Run the project on a local server like XAMPP or WAMP.
   - Access the website at `http://localhost/natudise`.

---

## Usage

### For Users:
- Register or log in to start shopping.
- Browse products, add to your cart, and place orders.
- Track your orders through the `My Orders` page.

### For Admins:
- Log in to the admin panel via `admin.php`.
- Add, update, or delete products and manage customer orders.

---

## Key Pages

1. **Home Page (`home.php`):**
   - Introduction to NATUDISE and its offerings.
2. **Products Page (`products.php`):**
   - Explore all available handmade products.
3. **Cart Page (`cart.php`):**
   - View selected items and proceed to checkout.
4. **Admin Dashboard (`admin_dashboard.php`):**
   - Comprehensive admin panel for managing the website.