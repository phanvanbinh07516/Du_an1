<?php
require_once('database/dbhelper.php');

// Kiểm tra số lượng đơn hàng có trạng thái "Đang chuẩn bị" trong bảng order_details
$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM order_details WHERE status = 'Đang chuẩn bị'";
$result_total_orders = executeSingleResult($sql_total_orders);
$totalOrders = 0;
if ($result_total_orders != null) {
    $totalOrders = $result_total_orders['total_orders'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Giỏ Hàng</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>

<body>
    <div id="wrapper">
        <header class="vertical-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="category/index.php">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category/index.php">Quản lý danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Quản lý giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client/">Quản lý khách hàng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <?php if ($totalOrders > 0) { ?>
                <div class="alert alert-info" role="alert">
                    Có <?php echo $totalOrders; ?> đơn hàng từ khách hàng!
                </div>
            <?php } ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Quản lý giỏ hàng</h2>
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-weight: 500;text-align: center;">
                                    <td width="50px">STT</td>
                                    <td width="200px">Tên User</td>
                                    <td>Tên Sản Phẩm/<br>Số lượng</td>
                                    <td>Tổng tiền</td>
                                    <td width="250px">Địa chỉ</td>
                                    <td>Số điện thoại</td>
                                    <td>Trạng thái</td>
                                    <!-- <td width="50px">Lưu</td> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    if (isset($_GET['page'])) {
                                        $page = $_GET['page'];
                                    } else {
                                        $page = 1;
                                    }
                                    $limit = 10;
                                    $start = ($page - 1) * $limit;

                                    $sql = "SELECT * FROM orders
                                            JOIN order_details ON orders.id = order_details.order_id
                                            JOIN product ON product.id = order_details.product_id
                                            ORDER BY order_date DESC LIMIT $start, $limit";
                                    $order_details_List = executeResult($sql);
                                    $total = 0;
                                    $count = 0;
                                    foreach ($order_details_List as $item) {
                                        echo '
                                            <tr style="text-align: center;">
                                                <td width="50px">' . (++$count) . '</td>
                                                <td style="text-align:center">' . $item['fullname'] . '</td>
                                                <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                <td width="100px">' . $item['address'] . '</td>
                                                <td width="100px">' . $item['phone_number'] . '</td>
                                                <td width="100px" class="green b-500">' . $item['status'] . '</td>
                                                <td width="100px">
                                                    <a href="edit.php?order_id=' . $item['order_id'] . '" class="btn btn-success">Edit</a>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                } catch (Exception $e) {
                                    die("Lỗi thực thi sql: " . $e->getMessage());
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <ul class="pagination">
                    <?php
                    $sql = "SELECT * FROM orders
                            JOIN order_details ON orders.id = order_details.order_id
                            JOIN product ON product.id = order_details.product_id";
                    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                    $result = mysqli_query($conn, $sql);
                    $current_page = 0;
                    if (mysqli_num_rows($result)) {
                        $numrow = mysqli_num_rows($result);
                        $current_page = ceil($numrow / 10);
                    }
                    for ($i = 1; $i <= $current_page; $i++) {
                        echo '
                            <li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>
                        ';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
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
        margin-left: 220px; /* Adjust based on the width of the vertical nav */
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

    .nav-tabs {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-radius: 0;
        margin-right: 5px;
    }

    .nav-tabs .nav-link.active {
        background-color: #343a40;
        color: #fff;
        border-color: #343a40;
    }
</style>

</html>
