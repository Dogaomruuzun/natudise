<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = "localhost";
$dbname = "natudise"; 
$username = "root"; 
$password = ""; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;


if (empty($email) || empty($password)) {
    echo "Email and password cannot be empty!";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $password === $user['password']) { 
  
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    
    if ($user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: home.php");
    }
    exit;
} else {
    echo "<p>Invalid email or password!</p>";
    exit;
}
?>
