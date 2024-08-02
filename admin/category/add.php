<?php
require_once('../database/dbhelper.php');
$id = $name = '';
if (!empty($_POST['name'])) {
    $name = '';
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $name = str_replace('"', '\\"', $name);
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }
    if (!empty($name)) {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        // Lưu vào DB
        if ($id == '') {
            // Thêm danh mục
            $sql = 'insert into category(name, created_at, updated_at) 
            values ("' . $name . '","' . $created_at . '","' . $updated_at . '")';
        } 
        else {
            // Sửa danh mục
            $sql = 'update category set name="' . $name . '", updated_at="' . $updated_at . '" where id=' . $id;
        }
        execute($sql);
        header('Location: index.php');
        die();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'select * from category where id=' . $id;
    $category = executeSingleResult($sql);
    if ($category != null) {
        $name = $category['name'];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Danh Mục</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

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
                    <h2 class="text-center">Thêm/Sửa Danh Mục</h2>
                </div>
                <div class="panel-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="name">Tên Danh Mục:</label>
                            <input type="text" id="id" name="id" value="<?= htmlspecialchars($id) ?>" hidden>
                            <input required="true" type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
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
</body>

</html>
