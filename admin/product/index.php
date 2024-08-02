<?php
require_once('../database/dbhelper.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Sản Phẩm</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    
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
                    <a class="nav-link active" href="../product/">Quản lý sản phẩm</a>
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
                    <h2 class="text-center">Quản lý Sản Phẩm</h2>
                </div>
                <div class="panel-body">
                    <a href="add.php">
                        <button class="btn btn-success" style="margin-bottom: 20px;">Thêm Sản Phẩm</button>
                    </a>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="font-weight: 500;">
                                <td >STT</td>
                                <td>Thumbnail</td>
                                <td>Tên Sản Phẩm</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Nội dung</td>
                               
                                <td >Acction</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách Sản Phẩm
                            if (!isset($_GET['page'])) {
                                $pg = 1;
                                echo 'Bạn đang ở trang:1 ';
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
                                $limit = 10;
                                $start = ($page - 1) * $limit;
                                $sql = "SELECT * FROM product limit $start,$limit";
                                executeResult($sql);
                                // $sql = 'select * from product limit $star,$limit';
                                $productList = executeResult($sql);

                                $index = 1;
                                foreach ($productList as $item) {
                                    echo '<tr>
                                        <td>' . ($index++) . '</td>
                                        <td style="text-align:center">
                                            <img src="' . $item['thumbnail'] . '" alt="" style="width: 50px">
                                        </td>
                                        <td>' . $item['title'] . '</td>
                                        <td>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</td>
                                        <td>' . $item['number'] . '</td>
                                        <td style="width: 200px;">' . $item['content'] . '</td>
                                        
                                        <td>
                                            <a href="add.php?id=' . $item['id'] . '" class="btn btn-warning btn-sm">Sửa</a>
                                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(' . $item['id'] . ')">Xoá</button>
                                        </td>
                                    </tr>';
                                }
                            } catch (Exception $e) {
                                die("Lỗi thực thi sql: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <ul class="pagination">
                <?php
                $sql = "SELECT * FROM `product`";
                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)) {
                    $numrow = mysqli_num_rows($result);
                    $current_page = ceil($numrow / 5);
                }
                for ($i = 1; $i <= $current_page; $i++) {
                    if ($i == $current_page) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        function deleteProduct(id) {
            var option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
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
        width: calc(100% - 220px);
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
        background-color: grey;
        font-weight: 500;
    }

    .dashboard .card-body span {
        font-size: 25px;
        font-weight: bold;
    }

    .table {
        margin-top: 20px;
    }
</style>

</html>
