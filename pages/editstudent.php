<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ct247dsDB";
            $id = $_GET['id'];
            try{
                $conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT _id,firstname,lastname,stuimg,imgtype FROM newSQL where _id=:id");
                $stmt->bindParam(":id",$id);
                
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll()[0];
        ?>
            <div style="text-align:center;margin:auto;">
                <h1 style="font-color:red">Student edit......</h1>
                <form action="./updatestudentinfo.php?id=<?php echo $result["_id"]?>" method="post" enctype="multipart/form-data">
                    old First name:<br>
                    <input type="text" disabled value="<?php echo $result["firstname"] ?>"><br>
                    new First name:<br>
                    <input type="text" name="firstname"><br><br>

                    old Last name:<br>
                    <input type="text" disabled value="<?php echo $result["lastname"] ?>"><br>
                    new Last name:<br>
                    <input type="text" name="lastname"><br>               
                    Student Image:<br>
                    <input type="file" name="stuimg"><br><br>
                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset">
                </form>
            </div>

    <?php
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    ?>
</body>
</html>