<?php
// Database connection
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare statements for category and item insertion
    $stmt1 = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt2 = $conn->prepare("INSERT INTO items (name, price, description, image, img_type, quantity, category_id) VALUES (:name, :price, :description, :image, :img_type, :quantity, :category_id)");

    // Bind parameters for category insertion
    $stmt1->bindParam(':name', $name);
    
    // Bind parameters for item insertion
    $stmt2->bindParam(':name', $itemName);
    $stmt2->bindParam(':price', $price);
    $stmt2->bindParam(':description', $description);
    $stmt2->bindParam(':image', $image);
    $stmt2->bindParam(':img_type', $img_type);
    $stmt2->bindParam(':quantity', $quantity);

    // Get form data
    $name = $_POST["categories"]; 
    $itemName = $_POST["itemName"]; 
    $price = $_POST["price"]; 
    $description = $_POST["desc"]; 
    $image = file_get_contents($_FILES["image"]["tmp_name"]); 
    $imgProperties = getimagesize($_FILES["image"]["tmp_name"]);
    $img_type = $imgProperties["mime"]; 
    $quantity = $_POST["quantity"]; 

    // Check if the category already exists
    $stmtCheckCategory = $conn->prepare("SELECT id FROM categories WHERE name = :name");
    $stmtCheckCategory->bindParam(':name', $name);
    $stmtCheckCategory->execute();
    $categoryId = $stmtCheckCategory->fetchColumn();

    if (!$categoryId) {
        // Insert new category and get the last inserted ID
        $stmt1->execute();
        $categoryId = $conn->lastInsertId(); 
    }

    // Bind the category ID for item insertion
    $stmt2->bindParam(':category_id', $categoryId); 
    // Execute item insertion
    $stmt2->execute();

    echo "<div style=\"text-align: center; margin-top: 20px;\">New item record created successfully.</div>";
    header("refresh:2;url=index.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}

// Close the connection
$conn = null;
?>
