<?php
// Database connection
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";


try {

    // connect to the newly created database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // Create tables
    $sqlStatements = [
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            description TEXT,
            image MEDIUMBLOB NOT NULL,
            img_type TEXT NOT NULL,
            quantity VARCHAR(50),
            category_id INT,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        )"
    ];
    
    foreach ($sqlStatements as $sql) {
        $conn->exec($sql);
    }
    echo "Tables created successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
