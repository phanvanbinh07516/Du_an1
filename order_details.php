<?php
require_once('database/dbhelper.php');
require_once('utils/utility.php');

// Lấy order_id từ GET request
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

// Kiểm tra xem order_id có tồn tại không
if ($order_id === null || !is_numeric($order_id)) {
    die('Order ID không hợp lệ.');
}

// Truy vấn thông tin chi tiết đơn hàng và thông tin khách hàng
$sql = "SELECT o.id as order_id, o.fullname, o.phone_number, o.email, o.address, o.order_date, o.status,
               od.product_id, od.num, od.price, p.title, p.thumbnail 
        FROM orders o
        JOIN order_details od ON o.id = od.order_id
        JOIN product p ON od.product_id = p.id
        WHERE o.id = '$order_id'";

$order_details = executeResult($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Chi Tiết Đơn Hàng</title>
</head>

<body>
    <div id="wrapper">
        <?php require('layout/header.php') ?>

        <main>
            <section class="order-details">
                <div class="container">
                    <h2>Chi Tiết Đơn Hàng</h2>
                    <?php if ($order_details) { ?>
                        <h4>Thông Tin Khách Hàng</h4>
                        <p><strong>Tên:</strong> <?php echo $order_details[0]['fullname']; ?></p>
                        <p><strong>Địa chỉ:</strong> <?php echo $order_details[0]['address']; ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo $order_details[0]['phone_number']; ?></p>
                        <h4>Chi Tiết Đơn Hàng</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_details as $item) { ?>
                                    <tr>
                                        <td>
                                            <img src="admin/product/<?php echo $item['thumbnail']; ?>" alt="<?php echo $item['title']; ?>" style="width: 100px;">
                                        </td>
                                        <td><?php echo $item['title']; ?></td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                        <td><?php echo $item['num']; ?></td>
                                        <td><?php echo number_format($item['num'] * $item['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Đơn hàng không tồn tại.</p>
                    <?php } ?>
                </div>
            </section>
        </main>

        <?php require('layout/footer.php'); ?>
    </div>
</body>
</html>
