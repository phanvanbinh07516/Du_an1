<?php
require_once('database/dbhelper.php');
require_once('utils/utility.php');

// Lấy danh sách sản phẩm trong giỏ hàng
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
    $idList = implode(',', $idList);
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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Giỏ hàng</title>
</head>
<?php
if (!isset($_COOKIE['username'])) {
    echo '<script>
        alert("Vui lòng đăng nhập để tiến hành mua hàng");
        window.location="login/login.php";
    </script>';   
}
?>
<body>
    <div id="wrapper">
        <?php require_once('layout/header.php'); ?>

        <!-- END HEADER -->
        <main>
            <section class="cart">
                <form action="api/checkout-form.php" method="POST">
                    <div class="container">
                        <h3 style="text-align: center;">Tiến hành đặt hàng</h3>
                        <div class="row">
                            <div class="panel panel-primary col-md-6">
                                <h4 style="padding: 2rem 0; border-bottom:1px solid black;">Nhập thông tin mua hàng</h4>
                                <div class="form-group">
                                    <label for="fullname">Họ và tên:</label>
                                    <input type="text" class="form-control" name="fullname" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Số điện thoại:</label>
                                    <input type="text" class="form-control" name="phone_number" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label for="note">Ghi chú:</label>
                                    <textarea class="form-control" rows="3" name="note" id="note"></textarea>
                                </div>
                            </div>
                            <div class="panel panel-primary col-md-6">
                                <h4 style="padding: 2rem 0; border-bottom:1px solid black;">Đơn hàng</h4>
                                <table class="table table-bordered table-hover none">
                                    <thead>
                                        <tr style="font-weight: 500;text-align: center;">
                                            <td width="50px">STT</td>
                                            <td>Tên Sản Phẩm</td>
                                            <td>Số lượng</td>
                                            <td>Tổng tiền</td>
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
                                        <td style="text-align:center; display:flex">
                                            <img src="admin/product/' . $item['thumbnail'] . '" alt="" style="width: 50px;margin:0 1rem 0 1rem;"> <span>' . $item['title'] . '</span>
                                        </td>
                                        <td width="100px">' . $num . '</td>
                                        <td class="b-500 red">' . number_format($num * $item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                    </tr>
                                    ';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <p>Tổng đơn hàng: <span class="bold red"><?= number_format($total, 0, ',', '.') ?><span> VNĐ</span></span></p>
                                <button class="btn btn-success" type="submit">Đặt hàng</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </main>
        <?php require_once('layout/footer.php'); ?>
    </div>
    <script type="text/javascript">
        function deleteCart(id) {
            $.post('api/cookie.php', {
                'action': 'delete',
                'id': id
            }, function(data) {
                location.reload()
            })
        }
    </script>
</body>
<style>
    .xemlai {
        font-size: 18px;
        font-weight: 500;
        color: blue;
    }

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