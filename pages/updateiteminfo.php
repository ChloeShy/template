<?php
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";

try {
    // Establish a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the item ID from the URL
    $itemId = $_GET['id'];

    // Retrieve the current item details
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

    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(':id', $itemId);
    $stmt2->execute();
    $inventory = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Prepare the SQL update statement
    $updateStmt = "UPDATE items 
                    SET name = :name, 
                        price = :price, 
                        description = :description, 
                        image = :image, 
                        img_type = :img_type, 
                        quantity = :quantity,
                        category_id = :category_id
                    WHERE id = :id";

    $stmt3 = $conn->prepare($updateStmt);

    // Bind parameters
    $stmt3->bindParam(':name', $_POST['itemName']);
    $stmt3->bindParam(':price', $_POST['price']);
    $stmt3->bindParam(':description', $_POST['desc']);
    $stmt3->bindParam(':quantity', $_POST['quantity']);
    $stmt3->bindParam(':category_id', $_POST['category']);
    $stmt3->bindParam(':id', $itemId); 

    // Initialize variables for image handling
    $imageData = null;
    $imgType = null;

    // Check if a new image is uploaded
    if (!empty($_FILES["image"]["tmp_name"])) {
        $imgProperties = getimagesize($_FILES["image"]["tmp_name"]);
        
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
        $imgType = $imgProperties["mime"];

        // Bind the image data if a new image is uploaded
        $stmt3->bindParam(':image', $imageData);
        $stmt3->bindParam(':img_type', $imgType);
    } else {
        // If no new image, set image and img_type to original one
        $image = $inventory['image']; 
        $imgType = $inventory['img_type']; 
        $stmt3->bindValue(':image', $image);
        $stmt3->bindValue(':img_type', $imgType);
    }

    // Execute the update statement
    if ($stmt3->execute()) {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Record updated successfully.</div>";
        header("refresh:2;url=index.php");
        exit; 
    } else {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Failed to update record.</div>";
    }

} catch (PDOException $e) {
    // Log the error message
    error_log($e->getMessage()); 
    echo "<div style=\"text-align: center; margin-top: 20px;\">Please make sure to enter all information. Please try again.</div>";
}

// Close the connection
$conn = null;
?>
