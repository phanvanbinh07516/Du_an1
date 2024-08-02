<?php require('layout/header.php') ?>
<style>
    .product-recently .row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px; /* Khoảng cách giữa các ảnh */
}

.product-recently .col {
    flex: 1 1 calc(25% - 15px); /* Đảm bảo có 4 ảnh trên mỗi hàng */
    box-sizing: border-box;
    margin: 7.5px; /* Khoảng cách giữa các cột */
}
.thumbnail {
    width: 100%; /* Đảm bảo ảnh chiếm toàn bộ chiều rộng của cột */
    height: 400px; /* Chiều cao tự động theo tỷ lệ ảnh */
    max-height: 700px; /* Giới hạn chiều cao tối đa của ảnh */
    object-fit: cover; /* Cắt ảnh để giữ tỷ lệ khung hình */
}

.col {
    display: flex;
    flex-direction: column;
}

.title p, .price span, .more {
    margin: 0;
    padding: 5px 0; /* Khoảng cách trên và dưới cho tiêu đề và giá */
}

.more {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9em;
    color: #666;
}

.more .star img, .more .time img {
    width: 16px; /* Điều chỉnh kích thước của các biểu tượng */
}
.time{
    color: red;
}
</style>
<header>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</header>
<main>
    <div class="container">
        <div id="ant-layout">
        <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="sanpham.php" method="GET">
                    <input name="search" type="text" placeholder="Tìm kiếm sản phẩm">
                </form>
            </section>
        </div>
        <!-- END LAYOUT  -->
        <section class="main">
            <?php
            if (isset($_GET['page'])) {
                $page = trim(strip_tags($_GET['page']));
            } else {
                $page = "";
            }
            switch ($page) {
                case "sanpham":
                    require('menu-con/aokhoac.php');
                    require('menu-con/caphe.php');
                    require('menu-con/monannhe.php');
                    require('menu-con/banhmi.php');
                    break;
                default:
                    break;
            }
            //switch
            if (isset($_GET['id_category'])) {
                $id_category = trim(strip_tags($_GET['id_category']));
            } else {
                $id_category = 0;
            }
            ?>
            <section class="recently">
                <div class="title">
                    <?php
                    $sql = "select * from category where id=$id_category";
                    $name = executeResult($sql);
                    foreach ($name as $ten) {
                        echo '<h1>' . $ten['name'] . '</h1>';
                    }
                    ?>
                </div>
                <div class="product-recently">
                    <div class="row">
                        <?php
                        $sql = "select * from product where id_category=$id_category";
                        $productList = executeResult($sql);
                        foreach ($productList as $item) {
                            echo '
                                <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img class="thumbnail" src="admin/product/' . $item['thumbnail'] . '" alt="">
                                        <div class="title">
                                            <p>' . $item['title'] . '</p>
                                        </div>
                                        <div class="price">
                                            <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</span>
                                        </div>
                                        <div class="more">
                                            <div class="star">
                                                <img src="images/icon/icon-star.svg" alt="">
                                                <span>4.6</span>
                                            </div>
                                            <div class="time">

                                                <span>Mới</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                        }
                        ?>
                        <?php
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = "SELECT * from product where title like '%$search%'";
                            $listSearch = executeResult($sql);
                            foreach ($listSearch as $item) {
                                echo '
                                <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img class="thumbnail" src="admin/product/' . $item['thumbnail'] . '" alt="">
                                        <div class="title">
                                            <p>' . $item['title'] . '</p>
                                        </div>
                                        <div class="price">
                                            <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</span>
                                        </div>
                                        <div class="more">
                                            <div class="star">
                                                <img src="images/icon/icon-star.svg" alt="">
                                                <span>4.6</span>
                                            </div>
                                            <div class="time">
                                                <img src="images/icon/icon-clock.svg" alt="">
                                                <span>15 comment</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
        </section>
    </div>
    <style>
        section.main section.recently .title h1 {
            border-bottom: 1px solid rgb(35, 54, 30);
        }
    </style>
    <?php require('layout/footer.php') ?>