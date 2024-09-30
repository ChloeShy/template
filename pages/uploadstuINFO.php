<?php
    $servername="localhost";
    $dbname = "ct247dsDB";
    $username="root";
    $password="";
    
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare(
            "INSERT INTO newSQL(firstname,lastname,stuimg,imgtype)values(:firstname,:lastname,:stuimg,:imgtype)"
        );

        $stmt2 = $conn->prepare(
            "INSERT INTO newSQL(firstname,lastname)values(:firstname,:lastname)"
        );
        $stmt->bindParam(":firstname",$firstname);
        $stmt->bindParam(":lastname",$lastname);
        $stmt->bindParam(":stuimg",$imgData);
        $stmt->bindParam(":imgtype",$imgtype);

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $imgData = file_get_contents($_FILES["stuimg"]["tmp_name"]);
        $imgProperties = getimageSize($_FILES["stuimg"]["tmp_name"]);
        $imgtype = $imgProperties["mime"];
        $stmt->execute();
        //echo "New record created!";
        header("Location: index.php");
        exit;
    }
    catch(PDOException $e){
        echo "Error:".$e->getMessage();
    }

    $iconn = null;
?>