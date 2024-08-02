<?php
require_once('database/dbhelper.php');
require_once('utils/utility.php');

$cart = [];
if (isset($_COOKIE['cart'])) {
    $json = $_COOKIE['cart'];
    $cart = json_decode($json, true);
}

$idList = [];
foreach ($cart as $item) {
    $idList[] = $item['id'];
}
if (count($idList) > 0) {
    $idList = implode(',', $idList); // Chuyển đổi mảng ID thành chuỗi phân cách bằng dấu phẩy

    $sql = "SELECT * FROM product WHERE id IN ($idList)";
    $cartList = executeResult($sql);
} else {
    $cartList = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Giỏ hàng</title>
</head>

<body>
    <div id="wrapper">
        <?php require_once('layout/header.php'); ?>
        <!-- END HEADER -->
        <main style="padding-bottom: 4rem;">
            <section class="cart">
                <div class="container-top">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding: 1rem 0;">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="cart.php">Giỏ hàng</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="history.php">Lịch sử mua hàng</a>
                                </li>
                            </ul>
                            <h2 style="padding-top:2rem" class="">Giỏ hàng</h2>
                        </div>
                        <div class="panel-body"></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-weight: 500;text-align: center;">
                                    <td width="50px">STT</td>
                                    <td>Ảnh</td>
                                    <td>Tên Sản Phẩm</td>
                                    <td>Giá</td>
                                    <td>Số lượng</td>
                                    <td>Tổng tiền</td>
                                    <td width="50px"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                $total = 0;
                                foreach ($cartList as $item) {
                                    $num = 0;
                                    foreach ($cart as $value) {
                                        if ($value['id'] == $item['id']) {
                                            $num = $value['num'];
                                            break;
                                        }
                                    }
                                    $total += $num * $item['price'];
                                    echo '
                                    <tr style="text-align: center;">
                                        <td width="50px">' . (++$count) . '</td>
                                        <td style="text-align:center">
                                            <img src="admin/product/' . $item['thumbnail'] . '" alt="" style="width: 50px">
                                        </td>
                                        <td>' . $item['title'] . '</td>
                                        <td class="b-500 red">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                        <td width="150px">
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(' . $item['id'] . ', -1)">-</button>
                                            <span id="quantity_' . $item['id'] . '">' . $num . '</span>
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(' . $item['id'] . ', 1)">+</button>
                                        </td>
                                        <td class="b-500 red"><span id="total_' . $item['id'] . '">' . number_format($num * $item['price'], 0, ',', '.') . '</span> <span>VNĐ</span></td>
                                        <td>
                                            <button class="btn btn-danger" onclick="deleteCart(' . $item['id'] . ')">Xoá</button>
                                        </td>
                                    </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                        <p>Tổng đơn hàng: <span class="red bold"><?= number_format($total, 0, ',', '.') ?><span> VNĐ</span></span></p>
                        <a href="checkout.php" onclick="checkLogin()"><button class="btn btn-success">Thanh toán</button></a>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once('layout/footer.php'); ?>
    </div>
    <script type="text/javascript">
        function updateQuantity(id, change) {
            var quantityElement = document.getElementById('quantity_' + id);
            var totalElement = document.getElementById('total_' + id);
            var currentQuantity = parseInt(quantityElement.textContent);
            var newQuantity = currentQuantity + change;

            if (newQuantity < 1) {
                alert('Số lượng không thể nhỏ hơn 1.');
                return;
            }

            $.post('api/cookie.php', {
                'action': 'update',
                'id': id,
                'quantity': newQuantity
            }, function(data) {
                var price = parseFloat(data.price); // Giá từ dữ liệu trả về
                quantityElement.textContent = newQuantity;
                totalElement.textContent = number_format(newQuantity * price, 0, ',', '.');

                // Cập nhật tổng tiền
                updateTotal();
            }, 'json');
        }

function updateTotal() {
    $.get('api/cookie.php', { 'action': 'getTotal' }, function(data) {
        document.querySelector('p span.red.bold').textContent = number_format(data.total, 0, ',', '.');
    }, 'json');
}


        function updateTotal() {
            $.get('api/cookie.php', { 'action': 'getTotal' }, function(data) {
                document.querySelector('p span.red.bold').textContent = number_format(data.total, 0, ',', '.');
            }, 'json');
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function deleteCart(id) {
            $.post('api/cookie.php', {
                'action': 'delete',
                'id': id
            }, function(data) {
                if (data.success) {
                    // Làm mới trang để cập nhật giỏ hàng
                    location.reload();
                } else {
                    alert('Xóa sản phẩm thất bại!');
                }
            }, 'json');
        }


        function checkLogin() {
            // Logic để kiểm tra đăng nhập (nếu cần)
        }
    </script>
</body>
<style>
    .b-500 {
        font-weight: 500;
    }

    .bold {
        font-weight: bold;
    }

    .red {
        color: rgba(207, 16, 16, 0.815);
    }
</style>
</html>
