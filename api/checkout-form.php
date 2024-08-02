<?php
// Đường dẫn chính xác đến dbhelper.php
require_once('../database/dbhelper.php'); // Sửa đường dẫn nếu cần thiết

if (!empty($_POST)) {
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    // Kiểm tra kết nối
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $json = $_COOKIE['cart'];
        $cart = json_decode($json, true);
    }

    if ($cart == null || count($cart) == 0) {
        header('Location: index.php');
        die();
    }

    // Xử lý dữ liệu từ form
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $note = mysqli_real_escape_string($con, $_POST['note']);
    $orderDate = date('Y-m-d H:i:s');

    // Thêm vào bảng orders
    $sql = "INSERT INTO orders (fullname, email, phone_number, address, note, order_date) 
            VALUES ('$fullname', '$email', '$phone_number', '$address', '$note', '$orderDate')";
    execute($sql);

    // Lấy ID của đơn hàng vừa tạo
    $sql = "SELECT * FROM orders WHERE order_date = '$orderDate' AND fullname = '$fullname' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $order = executeSingleResult($sql);
    $orderId = $order['id'];

    // Lấy ID của người dùng từ cookie (nếu có)
    $userId = null;
    if (isset($_COOKIE['username'])) {
        $username = mysqli_real_escape_string($con, $_COOKIE['username']);
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $user = executeSingleResult($sql);
        if ($user) {
            $userId = $user['id_user'];
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
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

    $status = 'Đang chuẩn bị';

    // Thêm chi tiết đơn hàng vào bảng order_details
    foreach ($cartList as $item) {
        $num = 0;
        foreach ($cart as $value) {
            if ($value['id'] == $item['id']) {
                $num = $value['num'];
                break;
            }
        }
        $sql = "INSERT INTO order_details (order_id, product_id, id_user, num, price, status) 
                VALUES ('$orderId', " . $item['id'] . ", '$userId', '$num', " . $item['price'] . ", '$status')";
        execute($sql);
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    setcookie('cart', '[]', time() - 3600, '/'); // Set cookie expiry time to past

    echo '<script language="javascript">
            alert("Đặt hàng thành công!"); 
            window.location = "../history.php";
        </script>';

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($con);
}
?>
