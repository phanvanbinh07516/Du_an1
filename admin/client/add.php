<?php
require_once('../database/dbhelper.php');

// Khởi tạo biến $id
$id = null;

// Kiểm tra nếu 'id' tồn tại trong $_GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Xử lý thêm và sửa người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = $_POST['hoten'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if ($id) {
        // Cập nhật người dùng
        $sql = "UPDATE user SET hoten='$hoten', username='$username', password='$password', phone='$phone', email='$email' WHERE id='$id'";
        execute($sql);
        echo "<script>alert('Cập nhật thành công'); window.location.href='index.php';</script>";
    } else {
        // Thêm người dùng mới
        $sql = "INSERT INTO user (hoten, username, password, phone, email) VALUES ('$hoten', '$username', '$password', '$phone', '$email')";
        execute($sql);
        echo "<script>alert('Thêm thành công'); window.location.href='index.php';</script>";
    }
}

// Lấy thông tin người dùng để sửa
$user = null;
if ($id) {
    $sql = "SELECT * FROM user WHERE id='$id'";
    $user = executeSingleResult($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $id ? 'Sửa người dùng' : 'Thêm người dùng'; ?></title>
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
            <h2><?php echo $id ? 'Sửa người dùng' : 'Thêm người dùng'; ?></h2>
            <form method="post">
                <div class="form-group">
                    <label for="hoten">Họ tên:</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo $user ? htmlspecialchars($user['hoten']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">User name:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user ? htmlspecialchars($user['username']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $user ? htmlspecialchars($user['password']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user ? htmlspecialchars($user['phone']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user ? htmlspecialchars($user['email']) : ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $id ? 'Cập nhật' : 'Thêm'; ?></button>
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</body>
</html>
