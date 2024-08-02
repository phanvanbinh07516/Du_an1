<?php
require_once('../database/dbhelper.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'update':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Lấy giỏ hàng từ cookie
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Cập nhật số lượng sản phẩm
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['num'] = $quantity;
                break;
            }
        }

        // Lưu giỏ hàng vào cookie
        setcookie('cart', json_encode($cart), time() + 3600, '/');

        // Lấy thông tin sản phẩm để trả về
        $sql = "SELECT price FROM product WHERE id = $id";
        $result = executeSingleResult($sql);
        $price = $result ? $result['price'] : 0;

        echo json_encode(['price' => $price]);
        break;

    case 'getTotal':
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $sql = "SELECT price FROM product WHERE id = " . $item['id'];
            $result = executeSingleResult($sql);
            $price = $result ? $result['price'] : 0;
            $total += $price * $item['num'];
        }

        echo json_encode(['total' => $total]);
        break;

    case 'delete':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        // Lấy giỏ hàng từ cookie
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Xóa sản phẩm khỏi giỏ hàng
        foreach ($cart as $key => $item) {
            if ($item['id'] == $id) {
                unset($cart[$key]);
                break;
            }
        }

        // Đặt lại cookie với giỏ hàng đã cập nhật
        setcookie('cart', json_encode(array_values($cart)), time() + 3600, '/');

        echo json_encode(['success' => true]);
        break;

    case 'add':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Lấy giỏ hàng từ cookie
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['num'] += $quantity;
                $found = true;
                break;
            }
        }

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        if (!$found) {
            $cart[] = ['id' => $id, 'num' => $quantity];
        }

        // Lưu giỏ hàng vào cookie
        setcookie('cart', json_encode($cart), time() + 3600, '/');

        echo json_encode(['success' => true]);
        break;

    case 'buy':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Lấy giỏ hàng từ cookie
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['num'] += $quantity;
                $found = true;
                break;
            }
        }

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        if (!$found) {
            $cart[] = ['id' => $id, 'num' => $quantity];
        }

        // Lưu giỏ hàng vào cookie
        setcookie('cart', json_encode($cart), time() + 3600, '/');

        // Chuyển hướng đến trang thanh toán
        echo json_encode(['success' => true, 'redirect' => 'checkout.php']);
        break;

    case 'getCartInfo':
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $json = $_COOKIE['cart'];
            $cart = json_decode($json, true);
        }

        // Đếm tổng số sản phẩm trong giỏ hàng
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['num'];
        }

        echo json_encode(['count' => $count]);
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>
