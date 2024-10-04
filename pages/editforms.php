<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>餐飲管理系統</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/startmin.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">餐飲管理系統</a>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav navbar-nav navbar-left navbar-top-links">
                <li><a href="#"><i class="fa fa-home fa-fw"></i> 儀表板</a></li>
            </ul>
            <ul class="nav navbar-right navbar-top-links">
                <li class="dropdown navbar-inverse">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <!-- Alerts here -->
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="index.php"><i class="fa fa-table fa-fw"></i> 查看存量</a></li>
                        <li><a href="forms.html"><i class="fa fa-edit fa-fw"></i> 建立項目</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">編輯項目</h1>
                </div>
            </div>
            <div style="margin:auto" class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php
                                    $host = "localhost";
                                    $dbname = "emenu"; 
                                    $username = "root";
                                    $password = "";

                                    try {
                                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        

                                        $query1 = "SELECT id, name FROM categories";
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
                                    

                                        
                                        $stmt1 = $conn->prepare($query1);
                                        $stmt1->execute();
                                        $categories = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                                        


                                        $itemId = $_GET['id'];
                                        

                                        $stmt2 = $conn->prepare($query2);
                                        $stmt2->bindParam(':id', $itemId);
                                        $stmt2->execute();
                                        $inventory = $stmt2->fetch(PDO::FETCH_ASSOC);
                                        

                                    } catch (PDOException $exception) {
                                        echo "Error: " . $exception->getMessage();
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>

                                    <form action="./updateiteminfo.php?id=<?php echo htmlspecialchars($inventory["item_id"]) ?>" method="post" enctype="multipart/form-data">
                                        <label style="font-size:30px;color:#76b5c5">編號: <?php echo $inventory["item_id"]?></label><br>
                                        <label for="categoryDropdown">目前種類</label>
                                        <select id="categoryDropdown" name="category" required>
                                            <option value="">目前種類</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id'] ?>" 
                                                    <?php echo $inventory['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                                    <?php echo $category['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br><br>
                                        <div class="form-group">
                                            <label for="newCategoryName">更新種類</label>
                                            <input  class="form-control" type="text" id="newcategory_name" name="newcategory_name" required>
                                            <p class="help-block">請輸入種類</p>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            
                                            <label>現時名稱</label>
                                            <input class="form-control" disabled value="<?php echo $inventory["item_name"] ?>">
                                            <label style="color:#76b5c5">新名稱</label>
                                            <input class="form-control" value="" name="itemName" required>
                                            <p class="help-block">請輸入名稱</p>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <label>現時價格</label>
                                            <input class="form-control" disabled value="<?php echo $inventory["price"]?>">
                                            <label style="color:#76b5c5">新價格</label>
                                            <input class="form-control" name="price" type="number" min="0" max="10000" step="0.01" value="<?php echo $inventory["price"]?>" required>
                                            <p class="help-block">請輸入價格</p>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <label>現時描述</label>
                                            <textarea class="form-control" rows="5" disabled><?php echo $inventory['description'] ?></textarea>
                                            <label style="color:#76b5c5">新描述</label>
                                            <textarea class="form-control" name="desc" rows="5" required></textarea>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <label>現時數量</label>
                                            <input class="form-control" disabled value="<?php echo $inventory["quantity"] ?>">
                                            <label style="color:#76b5c5">新數量</label>
                                            <input class="form-control" name="quantity" type="text" value="" required>
                                            <p class="help-block">請輸入數量</p>
                                        </div>
                                        <br><br>

                                        <div class="form-group">
                                            <label>圖片</label>
                                            <input class="btn btn-default" type="file" name="image" >
                                            <p class="help-block">請上載圖片</p>
                                            <br>
                                            <?php if (!empty($inventory['image'])): ?>
                                                <label>當前圖片：</label>
                                                <img src="data:<?php echo htmlspecialchars($inventory['img_type']); ?>;base64,<?php echo base64_encode($inventory['image']); ?>" style="max-width: 300px; max-height: 300px;"/>
                                            <?php endif; ?>
                                        </div>
                                      
                                            <button type="submit" class="btn btn-default" style="margin: 5px;">Submit</button>
                                            <button type="reset" class="btn btn-default" style="margin: 5px;">Reset</button>
                                        

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/metisMenu.min.js"></script>
        <script src="../js/startmin.js"></script>
    </body>
</html>
