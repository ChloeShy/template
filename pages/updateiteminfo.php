<?php
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 获取类别 ID 和新类别名称
    $categoryId = $_POST['category'];
    $newCategoryName = $_POST['newcategory_name'];

    // 检查并插入新类别
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

    // 更新项目
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