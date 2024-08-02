<?php
require_once('../database/dbhelper.php');
$id = $title = $price = $number = $thumbnail = $content = $id_category = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $title = isset($_POST['title']) ? str_replace('"', '\\"', $_POST['title']) : '';
    $id = isset($_POST['id']) ? str_replace('"', '\\"', $_POST['id']) : '';
    $price = isset($_POST['price']) ? str_replace('"', '\\"', $_POST['price']) : '';
    $number = isset($_POST['number']) ? str_replace('"', '\\"', $_POST['number']) : '';
    $content = isset($_POST['content']) ? str_replace('"', '\\"', $_POST['content']) : '';
    $id_category = isset($_POST['id_category']) ? str_replace('"', '\\"', $_POST['id_category']) : '';
    
    // Lấy dữ liệu từ sản phẩm hiện có
    if (!empty($id)) {
        $sql = 'SELECT thumbnail FROM product WHERE id=' . $id;
        $product = executeSingleResult($sql);
        if ($product != null) {
            $thumbnail = $product['thumbnail'];
        }
    }

    // Kiểm tra dữ liệu upload file
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
        $allowUpload = true;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $maxfilesize = 800000;
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
        if ($check === false) {
            echo "Không phải file ảnh.";
            $allowUpload = false;
        }

        if ($_FILES["thumbnail"]["size"] > $maxfilesize) {
            echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
            $allowUpload = false;
        }

        if (!in_array($imageFileType, $allowtypes)) {
            echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
            $allowUpload = false;
        }

        if ($allowUpload) {
            if (!move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                echo "Có lỗi xảy ra khi upload file.";
                die();
            } else {
                $thumbnail = $target_file; // Cập nhật đường dẫn thumbnail mới
            }
        } else {
            echo "Không upload được file, có thể do file lớn, kiểu file không đúng ...";
            die();
        }
    }

    // Lưu vào DB
    if (!empty($title)) {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        if (empty($id)) {
            $sql = 'INSERT INTO product (title, price, number, thumbnail, content, id_category, created_at, updated_at) 
                    VALUES ("' . $title . '","' . $price . '","' . $number . '","' . $thumbnail . '","' . $content . '","' . $id_category . '","' . $created_at . '","' . $updated_at . '")';
        } else {
            $sql = 'UPDATE product 
                    SET title="' . $title . '", price="' . $price . '", number="' . $number . '", thumbnail="' . $thumbnail . '", content="' . $content . '", id_category="' . $id_category . '", updated_at="' . $updated_at . '" 
                    WHERE id=' . $id;
        }
        execute($sql);
        header('Location: index.php');
        die();
    }
}

// Load dữ liệu sản phẩm khi chỉnh sửa
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
        $created_at = $product['created_at'];
        $updated_at = $product['updated_at'];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Sản Phẩm</title>
    <!-- Include Bootstrap and Summernote CSS/JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <style>
        /* CSS để đồng bộ hóa với các trang trước đó */
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
            margin-left: 220px;
            width: calc(100% - 220px);
        }

        .b-500 {
            font-weight: 500;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }

        .card-header {
            background-color: grey;
            font-weight: 500;
        }

        .dashboard .card-body span {
            font-size: 25px;
            font-weight: bold;
        }

        .table {
            margin-top: 20px;
        }

        .panel-heading {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: .25rem;
        }

        .panel-body {
            padding: 15px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .form-control-file {
            margin-bottom: 10px;
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
                    <a class="nav-link" href="index.php">Quản lý danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Quản lý giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../client/">Quản lý khách hàng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Thêm/Sửa Sản Phẩm</h2>
                </div>
                <div class="panel-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Tên Sản Phẩm:</label>
                            <input type="text" id="id" name="id" value="<?= htmlspecialchars($id) ?>" hidden="true">
                            <input required="true" type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_category">Chọn Danh Mục:</label>
                            <select class="form-control" id="id_category" name="id_category">
                                <option value="">Chọn danh mục</option>
                                <?php
                                $sql = 'SELECT * FROM category';
                                $categoryList = executeResult($sql);
                                foreach ($categoryList as $item) {
                                    if ($item['id'] == $id_category) {
                                        echo '<option selected value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá Sản Phẩm:</label>
                            <input required="true" type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($price) ?>">
                        </div>
                        <div class="form-group">
                            <label for="number">Số Lượng Sản Phẩm:</label>
                            <input required="true" type="number" class="form-control" id="number" name="number" value="<?= htmlspecialchars($number) ?>">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail:</label>
                            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
                            <?php if (!empty($thumbnail)): ?>
                                <img src="<?= htmlspecialchars($thumbnail) ?>" style="max-width: 200px" id="img_thumbnail">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="content">Nội dung:</label>
                            <textarea class="form-control" id="content" rows="3" name="content"><?= htmlspecialchars($content) ?></textarea>
                        </div>
                        <button class="btn btn-success">Lưu</button>
                        <?php
                        $previous = "javascript:history.go(-1)";
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            $previous = $_SERVER['HTTP_REFERER'];
                        }
                        ?>
                        <a href="<?= htmlspecialchars($previous) ?>" class="btn btn-warning">Back</a>
                    </form>
                </div>
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
