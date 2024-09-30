<?php
    // Database connection
    $host = "localhost";
    $dbname = "emenu"; 
    $username = "root";
    $password = "";
    
    try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        $stmt1 = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt2 = $conn->prepare("INSERT INTO items (name, price, description, image, img_type, quantity, category_id) VALUES (:name, :price, :description, :image, :img_type, :quantity, :category_id)");

        $stmt1->bindParam(':name', $name);
        $stmt2->bindParam(':name', $itemName);
        $stmt2->bindParam(':price', $price);
        $stmt2->bindParam(':description', $description);
        $stmt2->bindParam(':image', $image);
        $stmt2->bindParam(':img_type', $img_type);
        $stmt2->bindParam(':quantity', $quantity);

        $name = $_POST["categories"];
        $itemName = $_POST["itemName"];
        $price = $_POST["price"];
        $description = $_POST["desc"];
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $imgProperties = getimagesize($_FILES["image"]["tmp_name"]);
        // Capture image type
        $img_type = $imgProperties["mime"]; 
        $quantity = $_POST["quantity"];

        $stmtCheckCategory = $conn->prepare("SELECT id FROM categories WHERE name = :name");
        $stmtCheckCategory->bindParam(':name', $name);
        $stmtCheckCategory->execute();
        $categoryId = $stmtCheckCategory->fetchColumn();

        if (!$categoryId) {
            // Insert new category and get the last inserted ID
            $stmt1->execute();
            // Get the last created category ID
            $categoryId = $conn->lastInsertId(); 
        }

        $stmt2->bindParam(':category_id', $categoryId); 
        $stmt2->execute();
    
        echo "<div style=\"text-align: center; margin-top: 20px;\">New item record is created.</div>";
        header("refresh:2;url=index.php");
        exit();
    
    
    } catch(PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
    // Close the connection
    $con = null;
?>