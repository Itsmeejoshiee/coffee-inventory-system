<?php
$dsn = "mysql:host=localhost;dbname=coffeeshop";
$dbusername = "root";
$dbpassword = "";

try {
    // Attempt to create a new PDO instance
    $pdo = new PDO($dsn, $dbusername, $dbpassword);

    // Set PDO error mode to throw exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If an exception is caught, display an error message
    echo "Connection to the Database failed: " . $e->getMessage();
}

?>