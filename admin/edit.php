<?php require_once('database/dbhelper.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Chỉnh sửa đơn hàng</title>
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Chỉnh sửa đơn hàng</h2>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    if (isset($_GET['order_id'])) {
                                        $order_id = $_GET['order_id'];
                                    } else {
                                        throw new Exception("Không có ID đơn hàng.");
                                    }

                                    $count = 0;
                                    $sql = "SELECT * FROM orders
                                            JOIN order_details ON orders.id = order_details.order_id
                                            JOIN product ON product.id = order_details.product_id
                                            WHERE order_id = $order_id";
                                    $order_details_List = executeResult($sql);

                                    foreach ($order_details_List as $item) {
                                        $current_status = $item['status'];

                                        // Xử lý trạng thái
                                        if ($current_status == 'Đã hủy') {
                                            echo '
                                                <tr style="text-align: center;">
                                                    <td width="50px">' . (++$count) . '</td>
                                                    <td>' . $item['fullname'] . '</td>
                                                    <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                    <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                    <td>' . $item['address'] . '</td>
                                                    <td>' . $item['phone_number'] . '</td>
                                                    <td><strong>' . $current_status . '</strong></td>
                                                    <td>
                                                        <button class="btn btn-success" disabled>Đã hủy</button>
                                                    </td>
                                                </tr>
                                            ';
                                        } elseif ($current_status == 'Đang giao') {
                                            echo '
                                                <tr style="text-align: center;">
                                                    <td width="50px">' . (++$count) . '</td>
                                                    <td>' . $item['fullname'] . '</td>
                                                    <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                    <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                    <td>' . $item['address'] . '</td>
                                                    <td>' . $item['phone_number'] . '</td>
                                                    <td>
                                                        <select name="status">
                                                            <option value="Đã nhận hàng" selected>Đã nhận hàng</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success" type="submit">Lưu</button>
                                                    </td>
                                                </tr>
                                            ';
                                        } elseif ($current_status == 'Đã nhận hàng') {
                                            echo '
                                                <tr style="text-align: center;">
                                                    <td width="50px">' . (++$count) . '</td>
                                                    <td>' . $item['fullname'] . '</td>
                                                    <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                    <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                    <td>' . $item['address'] . '</td>
                                                    <td>' . $item['phone_number'] . '</td>
                                                    <td><strong>' . $current_status . '</strong></td>
                                                    <td>
                                                        <button class="btn btn-success" disabled>Đã nhận hàng</button>
                                                    </td>
                                                </tr>
                                            ';
                                        } else {
                                            // Cung cấp các tùy chọn trạng thái khác nếu không phải là "Đã hủy", "Đang giao", hoặc "Đã nhận hàng"
                                            $status_options = [
                                                'Đang chuẩn bị' => true,
                                                'Đang giao' => true,
                                                'Đã nhận hàng' => true,
                                                'Đã hủy' => true,
                                            ];

                                            // Loại bỏ các tùy chọn không hợp lệ dựa trên trạng thái hiện tại
                                            if ($current_status == 'Đang giao') {
                                                unset($status_options['Đang chuẩn bị']);
                                                unset($status_options['Đã hủy']);
                                            } elseif ($current_status == 'Đã nhận hàng' || $current_status == 'Đã hủy') {
                                                unset($status_options['Đang chuẩn bị']);
                                                unset($status_options['Đang giao']);
                                            }

                                            $options_html = '';
                                            foreach ($status_options as $status => $enabled) {
                                                $selected = ($status == $current_status) ? 'selected' : '';
                                                $options_html .= "<option value=\"$status\" $selected>$status</option>";
                                            }

                                            echo '
                                                <tr style="text-align: center;">
                                                    <td width="50px">' . (++$count) . '</td>
                                                    <td>' . $item['fullname'] . '</td>
                                                    <td>' . $item['title'] . '<br>(<strong>' . $item['num'] . '</strong>)</td>
                                                    <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                    <td>' . $item['address'] . '</td>
                                                    <td>' . $item['phone_number'] . '</td>
                                                    <td>
                                                        <select name="status">
                                                            ' . $options_html . '
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success" type="submit">Lưu</button>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    }
                                } catch (Exception $e) {
                                    die("Lỗi thực thi SQL: " . $e->getMessage());
                                }
                                ?>
                            </tbody>
                        </table>
                        <a href="dashboard.php" class="btn btn-warning">Quay lại</a>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $status = $_POST['status'];
                        // Cập nhật trạng thái trong bảng order_details
                        $sql = "UPDATE `order_details` SET `status` = '$status' WHERE `order_id` = $order_id";
                        execute($sql);
                        echo '<script language="javascript">
                        alert("Cập nhật thành công!");
                        window.location = "dashboard.php";
                     </script>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .b-500 {
    font-weight: 500;
}

.red {
    color: red;
}

.green {
    color: green;
}

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

.panel-heading {
    background-color: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #ddd;
    font-weight: 500;
}

.panel-body {
    padding: 20px;
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

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
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
