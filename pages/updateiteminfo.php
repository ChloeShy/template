<?php
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query2 = "SELECT 
        items.id AS item_id, 
        categories.id AS category_id, 
        categories.name AS category_name, 
        items.name AS item_name, 
        items.price, 
        items.description, 
        items.image, 
        items.img_type,
        items.quantity 
    FROM items 
    INNER JOIN categories ON items.category_id = categories.id
    WHERE items.id = :id";


    $categoryId = $_POST['category'];
    $newCategoryName = $_POST['newcategory_name'];

    if (!empty($newCategoryName)) {
        $checkStmt = $conn->prepare("SELECT id FROM categories WHERE name = :name");
        $checkStmt->bindParam(':name', $newCategoryName);
        $checkStmt->execute();
        $existingCategoryId = $checkStmt->fetchColumn();

        if (!$existingCategoryId) {
            $insertStmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $insertStmt->bindParam(':name', $newCategoryName);
            $insertStmt->execute();
            $categoryId = $conn->lastInsertId();
        } else {
            $categoryId = $existingCategoryId;
        }
    }

    $updateStmt = $conn->prepare("UPDATE items 
        SET name = :name, 
            price = :price, 
            description = :description, 
            image = :image, 
            img_type = :img_type, 
            quantity = :quantity,
            category_id = :category_id
        WHERE id = :id");

    $itemId = $_GET['id'];
    $itemName = $_POST['itemName'];
    $price = $_POST['price'];
    $description = $_POST['desc'];
    $quantity = $_POST['quantity'];

    if (!empty($_FILES["image"]["tmp_name"])) {
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
        $imgType = getimagesize($_FILES["image"]["tmp_name"])["mime"];
    } else {
        $imageData = null; // Use existing image if not uploaded
        $imgType = null;
    }

    $updateStmt->bindParam(':name', $itemName);
    $updateStmt->bindParam(':price', $price);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':quantity', $quantity);
    $updateStmt->bindParam(':category_id', $categoryId);
    $updateStmt->bindParam(':id', $itemId);

    $itemId = $_GET['id'];
                                        

    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(':id', $itemId);
    $stmt2->execute();
    $inventory = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($imageData !== null) {
        $updateStmt->bindParam(':image', $imageData);
        $updateStmt->bindParam(':img_type', $imgType);
    } else {
        // Set the image parameters to their existing values if not updated
        $image = $inventory['image'];
        $imgType = $inventory['img_type'];
        $updateStmt->bindValue(':image', $image);
        $updateStmt->bindValue(':img_type', $imgType);
    }

    if ($updateStmt->execute()) {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Record updated successfully.</div>";
        header("refresh:2;url=index.php");
        exit; 
    } else {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Failed to update record.</div>";
    }

} catch (PDOException $e) {
    echo "<div style=\"text-align: center; margin-top: 20px;\">Error: " . $e->getMessage() . "</div>";
}

$conn = null;
?>