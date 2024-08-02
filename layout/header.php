<!DOCTYPE html>
<html lang="en">
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/details.css">
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <title>KENTA</title>
    <style>

        /* Phần đăng nhập */
        .login {
            position: relative;
            display: inline-block;
            margin-left: 20px;
            font-size: 1em;
        }


        .login a:hover {
            background-color: #e1e1e1;
        }

        .logout {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .logout a {
            display: block;
            padding: 5px 0;
            color: #333;
            text-decoration: none;
            font-size: 0.9em;
        }

        .logout a:hover {
            background-color: #f1f1f1;
        }

        .login:hover .logout {
            display: block;
        }

        /* Icon styling */
        .logout a i {
            margin-right: 5px;
        }

    </style>
</head>

<body>
    <div id="wrapper">
        <header>
            <div class="container">
                <section class="logo">
                    <a href="index.php"><h3>KENTA.vn</h3></a>
                </section>
                <nav>
                    <ul>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li class="nav-cha">
                            <a href="sanpham.php?page=sanpham">Sản Phẩm</a>
                            <ul class="nav-con">
                                <?php
                                    $sql="SELECT * FROM category";
                                    $result=executeResult($sql);
                                    foreach($result as $item){
                                        echo '<li><a href="sanpham.php?id_category=' . $item['id'] . '">'.$item['name'].'</a></li>';
                                    }
                                ?>
                                
                            </ul>
                        </li>
                        <li><a href="about.php">Về chúng tôi</a></li>
                        <li><a href="sendMail.php">Liên hệ</a></li>
                    </ul>
                </nav>
                <section class="menu-right">
                    <div class="cart">
                        <a href="cart.php"><img src="images/icon/cart.svg" alt=""></a>
                        <?php
                        $cart = [];
                        if (isset($_COOKIE['cart'])) {
                            $json = $_COOKIE['cart'];
                            $cart = json_decode($json, true);
                        }
                        $count = 0;
                        foreach ($cart as $item) {
                            $count += $item['num']; // đếm tổng số item
                        }
                        ?>
                        <span><?= $count ?></span>
                        <!-- <div class="history">
                            <a href="history.php"><i class="fas fa-history" style="font-size: 14px;"></i>Lịch sử</a>
                        </div> -->
                    </div>
                    <div class="login">
                        <?php
                        if (isset($_COOKIE['username'])) {
                            $username=$_COOKIE['username'];
                            if ($username == 'AdminThanh'|| $username == 'admin') {
                                echo '<a style="color:black;" href="">' . $_COOKIE['username'] . '</a>
                                <div class="logout">
                                    <a href="admin/"><i class="fas fa-user-edit"></i>Admin</a> <br>
                                    <a href="login/logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                                </div>';
                            }
                            else{
                                echo '<a style="color:black;" href="">' . $_COOKIE['username'] . '</a>
                            <div class="logout">
                                <a href="login/changePass.php"><i class="fas fa-exchange-alt"></i>Đổi mật khẩu</a> <br>
                                <a href="login/logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                            </div>
                            ';
                            }
                        } 
                        else {
                            echo '<a href="login/login.php"">Đăng nhập</a>';
                        }

                        ?>
                    </div>
                </section>
            </div>
        </header>