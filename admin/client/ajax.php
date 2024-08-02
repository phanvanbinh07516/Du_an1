<?php
require_once('../database/dbhelper.php');

// Nhận ID người dùng từ yêu cầu POST
$id = isset($_POST['id']) ? $_POST['id'] : null;

// Kiểm tra nếu ID không tồn tại thì chuyển hướng về trang quản lý người dùng
if (!$id) {
    header('Location: manage_users.php');
    exit();
}

// Xóa người dùng
$sql = "DELETE FROM user WHERE id_user='$id'";
execute($sql);

// Trả về phản hồi cho AJAX
echo json_encode(['status' => 'success']);
?>
