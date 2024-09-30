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

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="../css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="../css/dataTables/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
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
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">       
                            <li>
                                <a href="index.php"><i class="fa fa-table fa-fw"></i> 查看存量</a>
                            </li>
                            <li>
                                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> 建立項目</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">項目總表</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>編號</th>
                                                <th>種類</th>
                                                <th>名稱</th>
                                                <th>價錢</th>
                                                <th>描述</th>
                                                <th>數量</th>
                                                <th>圖片</th>
                                                <th>編輯</th>
                                                <th>刪除</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $host = "localhost";
                                                $dbname = "emenu"; 
                                                $username = "root";
                                                $password = "";
                                                try{
                                               
                                                    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
                                                    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                                    $stmt = $conn->prepare("SELECT 
                                                                                items.id AS item_id, 
                                                                                categories.id AS category_id, 
                                                                                categories.name AS category_name, 
                                                                                items.name AS item_name, 
                                                                                items.price, 
                                                                                items.description, 
                                                                                items.image, 
                                                                                items.quantity 
                                                                            FROM items 
                                                                            INNER JOIN categories ON items.category_id = categories.id");
                                                    $stmt ->execute();
                                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    
                                                    foreach($results as $row){
                                                ?>
                                                    <tr>
                                                        <td style="width:150px;">
                                                            <?php echo $row["item_id"]?>
                                                        </td>
                                                        <td style="width:150px;">
                                                            <?php echo $row["category_name"]?>
                                                        </td>
                                                        <td style="width:150px;">
                                                             <?php echo $row["item_name"]?>
                                                        </td>
                                                        <td style="width:150px;">
                                                             <?php echo $row["price"]?>
                                                        </td>
                                                        <td style="width:150px;">
                                                             <?php echo $row["description"]?>
                                                        </td>
                                                        <td style="width:150px;">
                                                             <?php echo $row["quantity"]?>
                                                        </td>
                                                        <td style="width:500px;">
                                                          <?php echo
                                                                    '<img width="80%" src="data:'
                                                                    .$row["img_type"]
                                                                    .";base64,"
                                                                    .base64_encode($row["image"]).
                                                                    '">';?>
                                                                <!-- echo '<img width="100%" src="data:'image/png;base64,??????'">' -->
                                                        </td>
                                                        <td style="width:150px;">
                                                            <?php
                                                              echo '<a href="editforms.php?id=' . $row["item_id"].'">Edit</a>'
                                                            ?>
                                                        </td>
                                                        <td style="width:150px;">
                                                            <?php
                                                              echo '<a href="delete.php?id=' . $row["item_id"].'">Delete</a>'
                                                            ?>
                                                        </td>                  
                                                    </tr>
                                                    
                                            <?php 
                                                }
                                            }catch(PDOException $e){
                                                echo "Error: " . $e->getMessage();
                                            }
                                            $conn = null;
                                            ?>

                                            <!-- <tr class="gradeU">
                                                <td>Other browsers</td>
                                                <td>All others</td>
                                                <td>-</td>
                                                <td class="center">-</td>
                                                <td class="center">U</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <!-- <div class="well">
                                    <h4>DataTables Usage Information</h4>
                                    <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website at <a target="_blank" href="https://datatables.net/">https://datatables.net/</a>.</p>
                                    <a class="btn btn-default btn-lg btn-block" target="_blank" href="https://datatables.net/">View DataTables Documentation</a>
                                </div> -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <!-- /.row -->
               
                <!-- /.row -->
                
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>

    </body>
</html>
