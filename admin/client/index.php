<?php
require_once('../database/dbhelper.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Khách Hàng</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #wrapper {
            display: flex;
            padding-bottom: 5rem;
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

     

        .panel {
           
            border-radius: 4px;
            background-color: #fff;
        }

        .panel-heading {
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            font-weight: 500;
        }

        .panel-body {
            padding: 20px;
            margin-left: 20px;
        }

        .table {
            margin-top: 20px;
        }

        .table td {
            padding: 8px;
            vertical-align: middle;
        }

        .table thead tr {
            font-weight: 500;
        }

        .table .btn {
            margin: 0 5px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            padding: 8px 16px;
            
            border-radius: 4px;
            color: #007bff;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link {
            background-color: #343a40;
            color: #fff;
            
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
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

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .w-70 {
            width: 70px;
        }

        .w-50 {
            width: 50px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <header class="vertical-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../category/">Quản lý Danh Mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Quản lý giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../client/">Quản lý khách hàng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <div class="panel panel-primary">
                <div class="">
                    <h2 class="text-center">Quản lý khách hàng</h2>
                </div>
                <div class="panel-body">
                    <a href="add.php">
                        <button class="btn btn-success" style="margin-bottom:20px">Thêm người dùng</button>
                    </a>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="font-weight: 500;">
                                <td class="w-70">STT</td>
                                <td>ID user</td>
                                <td>Họ tên</td>
                                <td>User name</td>
                                <td>Password</td>
                                <td>Phone</td>
                                <td>Email</td>
                                <td>Acction</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách khách hàng
                            if (!isset($_GET['page'])) {
                                $pg = 1;
                                echo 'Bạn đang ở trang: 1';
                            } else {
                                $pg = $_GET['page'];
                                echo 'Bạn đang ở trang: ' . $pg;
                            }

                            try {
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                $limit = 5;
                                $start = ($page - 1) * $limit;
                                $sql = "SELECT * FROM user LIMIT $start, $limit";
                                $userList = executeResult($sql);

                                $index = 1;
                                foreach ($userList as $item) {
                                    echo '
                                        <tr>
                                            <td>' . ($index++) . '</td>
                                            <td>' . $item['id_user'] . '</td>
                                            <td>' . $item['hoten'] . '</td>
                                            <td>' . $item['username'] . '</td>
                                            <td>' . $item['password'] . '</td>
                                            <td>' . $item['phone'] . '</td>
                                            <td>' . $item['email'] . '</td>
                                            <td>
                                                <a href="edit.php?id=' . $item['id_user'] . '">
                                                    <button class="btn btn-warning">Sửa</button> 
                                                </a> 
                                                <button class="btn btn-danger" onclick="deleteUser(' . $item['id_user'] . ')">Xoá</button>
                                            </td>
                                           
                                        </tr>';
                                }
                            } catch (Exception $e) {
                                die("Lỗi thực thi SQL: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <ul class="pagination">
                <?php
                $sql = "SELECT * FROM `user`";
                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)) {
                    $numrow = mysqli_num_rows($result);
                    $current_page = ceil($numrow / 5);
                }
                for ($i = 1; $i <= $current_page; $i++) {
                    if ($i == $pg) {
                        echo '
                            <li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '
                            <li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>
                        ';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        function deleteUser(id) {
            var option = confirm('Bạn có chắc chắn muốn xoá không?');
            if (!option) {
                return;
            }

            $.post('ajax.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload();
            });
        }
    </script>
</body>

</html>
