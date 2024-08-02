<?php
require_once('../database/dbhelper.php');

// Khởi tạo biến $id
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Kiểm tra nếu id không tồn tại thì chuyển hướng về trang quản lý người dùng
if (!$id) {
    header('Location: index.php');
    exit();
}

// Xử lý cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = $_POST['hoten'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Cập nhật người dùng
    $sql = "UPDATE user SET hoten='$hoten', username='$username', password='$password', phone='$phone', email='$email' WHERE id_user='$id'";
    execute($sql);
    echo "<script>alert('Cập nhật thành công'); window.location.href='index.php';</script>";
}

// Lấy thông tin người dùng để sửa
$sql = "SELECT * FROM user WHERE id_user='$id'";
$user = executeSingleResult($sql);

// Nếu không tìm thấy người dùng, chuyển hướng về trang quản lý người dùng
if (!$user) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sửa người dùng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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

        .container {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
            <h2>Sửa người dùng</h2>
            <form method="post">
                <div class="form-group">
                    <label for="hoten">Họ tên:</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo htmlspecialchars($user['hoten']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">User name:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</body>

</html>
