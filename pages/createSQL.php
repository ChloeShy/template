<?php
// Database connection
$host = "localhost";
$dbname = "emenu";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin transaction
    $conn->beginTransaction();

    // Insert categories
    $categoryNames = ['飲品', '麵', '飯'];
    $categoryIds = [];

    foreach ($categoryNames as $name) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        $categoryIds[$name] = $conn->lastInsertId();
    }

    // Prepare SQL for items
    $stmt = $conn->prepare("INSERT INTO items (name, price, description, image, img_type, quantity, category_id) 
                            VALUES (:name, :price, :description, :image, :img_type, :quantity, :category_id)");

    // Read image files
    $images = [
        ['name' => '手打檸檬茶', 'price' => 30, 'description' => '來自鍚蘭', 'file' => '../images/lemontea.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['飲品']],
        ['name' => '星洲炒米', 'price' => 60, 'description' => '唔係來自星洲', 'file' => '../images/星洲炒米.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['麵']],
        ['name' => '過橋米線', 'price' => 50, 'description' => '來自四川雲南', 'file' => '../images/米線.jpeg', 'img_type' => 'image/jpeg', 'quantity' => '100', 'category_id' => $categoryIds['麵']]
    ];

    foreach ($images as $image) {
        $imageData = file_get_contents($image['file']);
        if ($imageData === false) {
            throw new Exception("Failed to read image file: " . $image['file']);
        }

        // Bind parameters
        $stmt->bindParam(':name', $image['name']);
        $stmt->bindParam(':price', $image['price']);
        $stmt->bindParam(':description', $image['description']);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':img_type', $image['img_type']);
        $stmt->bindParam(':quantity', $image['quantity']);
        $stmt->bindParam(':category_id', $image['category_id']);

        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();
    echo "Success.";
} catch (Exception $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>