<?php
require_once('../database/dbhelper.php');

// Khởi tạo biến
$id = $title = $price = $number = $thumbnail = $content = $id_category = "";
$upload_success = "";

// Xử lý cập nhật thông tin sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = trim(strip_tags($_POST['id']));
    }
    if (isset($_POST['title'])) {
        $title = trim(strip_tags($_POST['title']));
    }
    if (isset($_POST['price'])) {
        $price = trim(strip_tags($_POST['price']));
    }
    if (isset($_POST['number'])) {
        $number = trim(strip_tags($_POST['number']));
    }
    if (isset($_POST['content'])) {
        $content = trim(strip_tags($_POST['content']));
    }
    if (isset($_POST['id_category'])) {
        $id_category = trim(strip_tags($_POST['id_category']));
    }

    // Kiểm tra có dữ liệu thumbnail trong $_FILES không
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        // Thư mục lưu trữ file
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');
        $maxfilesize = 800000; // 800KB

        // Kiểm tra xem file có phải là ảnh không
        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
        if ($check === false) {
            $upload_success = "Không phải file ảnh.";
        } else if ($_FILES["thumbnail"]["size"] > $maxfilesize) {
            $upload_success = "Kích thước file quá lớn.";
        } else if (!in_array($imageFileType, $allowtypes)) {
            $upload_success = "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF.";
        } else {
            // Xử lý upload file
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                $thumbnail = $target_file;
            } else {
                $upload_success = "Có lỗi xảy ra khi upload file.";
            }
        }
    }

    // Cập nhật sản phẩm trong cơ sở dữ liệu
    if (!empty($title)) {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        if ($id == '') {
            // Thêm sản phẩm mới
            $sql = 'INSERT INTO product (title, price, number, thumbnail, content, id_category, created_at, updated_at) 
                    VALUES ("' . $title . '", "' . $price . '", "' . $number . '", "' . $thumbnail . '", "' . $content . '", "' . $id_category . '", "' . $created_at . '", "' . $updated_at . '")';
        } else {
            // Cập nhật sản phẩm
            $sql = 'UPDATE product 
                    SET title="' . $title . '", price="' . $price . '", number="' . $number . '", thumbnail="' . $thumbnail . '", content="' . $content . '", id_category="' . $id_category . '", updated_at="' . $updated_at . '" 
                    WHERE id=' . $id;
        }
        execute($sql);
        header('Location: index.php');
        exit();
    }
}

// Lấy thông tin sản phẩm nếu có ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM product WHERE id=' . $id;
    $product = executeSingleResult($sql);
    if ($product != null) {
        $title = $product['title'];
        $price = $product['price'];
        $number = $product['number'];
        $thumbnail = $product['thumbnail'];
        $content = $product['content'];
        $id_category = $product['id_category'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh Sửa Sản Phẩm</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i>Thống kê</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php">Quản lý danh mục</a></li>
        <li class="nav-item"><a class="nav-link" href="../product/">Quản lý sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Quản lý giỏ hàng</a></li>
        <li class="nav-item"><a class="nav-link" href="../client/">Quản lý khách hàng</a></li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Chỉnh Sửa Sản Phẩm</h2>
            </div>
            <div class="panel-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="title">Tên Sản Phẩm:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_category">Chọn Danh Mục:</label>
                        <select class="form-control" id="id_category" name="id_category">
                            <option value="">Chọn danh mục</option>
                            <?php
                            $sql = 'SELECT * FROM category';
                            $categoryList = executeResult($sql);
                            foreach ($categoryList as $item) {
                                echo '<option value="' . $item['id'] . '"' . ($item['id'] == $id_category ? ' selected' : '') . '>' . $item['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá Sản Phẩm:</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= $price ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Số Lượng:</label>
                        <input type="number" class="form-control" id="number" name="number" value="<?= $number ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail:</label>
                        <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
                        <?php if ($thumbnail): ?>
                            <img src="<?= $thumbnail ?>" style="max-width: 200px;" alt="Thumbnail Preview">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội Dung:</label>
                        <textarea class="form-control" id="content" name="content" rows="3"><?= $content ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                    <a href="index.php" class="btn btn-warning">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#content').summernote({
                height: 200
            });
        });
    </script>
</body>
</html>
