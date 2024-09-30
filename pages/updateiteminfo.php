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
    $itemId = $_GET['id']; // Added semicolon here

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

    $stmt = $conn->prepare($updateStmt);

    // Bind parameters
    $stmt->bindParam(':name', $_POST['itemName']);
    $stmt->bindParam(':price', $_POST['price']);
    $stmt->bindParam(':description', $_POST['desc']);
    $stmt->bindParam(':quantity', $_POST['quantity']);
    $stmt->bindParam(':category_id', $_POST['category']);
    $stmt->bindParam(':id', $itemId); 

    // Initialize variables for image handling
    $imageData = null;
    $imgType = null;

    // Check if a new image is uploaded
    if (!empty($_FILES["image"]["tmp_name"])) {
        $imgProperties = getimagesize($_FILES["image"]["tmp_name"]);
        
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
        $imgType = $imgProperties["mime"];

        // Bind the image data if a new image is uploaded
        $stmt->bindParam(':image', $imageData);
        $stmt->bindParam(':img_type', $imgType);
    } else {
        // If no new image, set image and img_type to NULL
        $stmt->bindValue(':image', null);
        $stmt->bindValue(':img_type', null);
    }

    // Execute the update statement
    if ($stmt->execute()) {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Record updated successfully.</div>";
        header("refresh:2;url=index.php");
        exit; 
    } else {
        echo "<div style=\"text-align: center; margin-top: 20px;\">Failed to update record.</div>";
    }

} catch (PDOException $e) {
    // Log the error message
    error_log($e->getMessage()); 
    echo "<div style=\"text-align: center; margin-top: 20px;\">An error occurred. Please try again later.</div>";
}

// Close the connection
$conn = null;
?>
