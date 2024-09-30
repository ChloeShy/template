<?php

// Database connection
$host = "localhost";
$dbname = "emenu";
$username = "root";
$password = "";


try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    // Insert data
    $categoryStatements = [
        "INSERT INTO categories (name) VALUES ('飲品')",
        "INSERT INTO categories (name) VALUES ('麵')",
        "INSERT INTO categories (name) VALUES ('飯')"
    ];

    foreach ($categoryStatements as $cat) {
        $conn->exec($cat);
    }

    $itemStatements = [
        "INSERT INTO items (name, price, description, image, img_type, quantity, category_id) VALUES ('手打檸檬茶', 30, '來自鍚蘭', NULL, 'image/jpeg', '50', 1)",
        "INSERT INTO items (name, price, description, image, img_type, quantity, category_id) VALUES ('星洲炒米', 60, '唔係來自星洲', NULL, 'image/jpeg', '50', 2)",
        "INSERT INTO items (name, price, description, image, img_type, quantity, category_id) VALUES ('過橋米線', 50, '來自四川雲南', NULL, 'image/jpeg', '100', 2)"
    ];
    
    
    $conn->commit();
        echo "success.";
}
catch(PDOException $e){
    $conn->rollBack();
    echo $sql."<br>".$e->getMessage();
}


$conn = null;

?>