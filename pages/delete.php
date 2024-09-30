<?php
$host = "localhost";
$dbname = "emenu"; 
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id'])) {
        die('Record ID not found.');
    }

    // Get ID
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM items WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "<div style=\"text-align: center; margin-top: 20px;\">Delete successful.</div>";
    header("refresh:2;url=index.php");

} catch (PDOException $exception) {
    echo json_encode(array('result' => 'error', 'message' => $exception->getMessage()));
}

$conn = null;
?>