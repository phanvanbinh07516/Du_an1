<?php
require_once('../database/dbhelper.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Danh Mục</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div id="wrapper">
        <header class="vertical-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../category/">Quản lý danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Quản lý giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../client/">Quản lý khách hàng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Quản lý danh mục</h2>
                </div>
                <div class="panel-body">
                    <a href="add.php">
                        <button class="btn btn-success" style="margin-bottom: 20px;">Thêm Danh Mục</button>
                    </a>
                    <table class=" table table-bordered ">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách danh mục
                            $sql = 'select * from category';
                            $categoryList = executeResult($sql);
                            $index = 1;
                            foreach ($categoryList as $item) {
                                echo '<tr>
                                    <td>' . ($index++) . '</td>
                                    <td>' . $item['name'] . '</td>
                                    <td>
                                        <a href="add.php?id=' . $item['id'] . '">
                                            <button class="btn btn-warning">Sửa</button>
                                            <button class="btn btn-danger" onclick="deleteCategory(' . $item['id'] . ')">Xoá</button>
                                        </a>
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function deleteCategory(id) {
            var option = confirm('Bạn có chắc chắn muốn xoá danh mục này không?')
            if (!option) {
                return;
            }
            console.log(id)
            $.post('ajax.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload()
            })
        }
    </script>
</body>

<style>
    #wrapper {
        padding-bottom: 5rem;
        display: flex;
    }

    .vertical-nav {
        width: 200px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #343a40;
        padding-top: 20px;
    }

    .vertical-nav .nav-link {
        color: #fff;
        padding: 10px 15px;
        text-align: left;
    }

    .vertical-nav .nav-link:hover {
        background-color: #495057;
    }

    .container {
        margin-left: 220px;
        padding: 20px;
        
      
       
    }

    .b-500 {
        font-weight: 500;
    }

    .red {
        color: red;
    }

    .green {
        color: green;
    }

    .card-header {
        
        font-weight: 500;
    }

    .dashboard .card-body span {
        font-size: 25px;
        font-weight: bold;
    }

    .table {
        margin-top: 20px;
   
        
    }

    .panel-heading {
        margin-bottom: 20px;
        padding: 10px;
        
        
        
    }

    .panel-body {
        padding: 20px;
        
       
       
    }

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        font-size: 14px;
        border-radius: 4px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
</style>

</html>
