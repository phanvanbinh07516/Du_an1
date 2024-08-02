<head>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet"  href=".css/style.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<?php require "layout/header.php"; ?>
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
?>
<!-- END HEADER -->
 <!-- Phần banner -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/img/banner1.png" class="d-block w-100 h-70" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Thời Trang Nam Đẳng Cấp</h5>
                <p>Khám phá phong cách của bạn với những bộ sưu tập mới nhất.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/img/banner2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Bộ Sưu Tập Mùa Hè</h5>
                <p>Những mẫu thiết kế thời thượng cho mùa hè năng động.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/img/banner.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Ưu Đãi Đặc Biệt</h5>
                <p>Giảm giá lên tới 50% cho các sản phẩm mới.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<!-- Đổ sản phẩm -->
<main>
    <div class="container">
        <div id="ant-layout">
            <!-- <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="thucdon.php" method="GET">
                    <input name="search" type="text" placeholder="Tìm sản phẩm">
                </form>
            </section> -->
            
        </div>
        <div class="bg-grey">

        </div>
        <!-- END LAYOUT  -->
        <section class="main">
            <section class="restaurants">
                <div class="title">
                    <h5>Sản Phẩm Mới <span class="green"></span></h5>
                </div>
                <section class="main-layout">
                <div class="row">
                    <?php
                    $sql = 'select * from category';
                    $categoryList = executeResult($sql);
                    $index = 1;
                    foreach ($categoryList as $item) {
                        echo '
                                    <div class="box">
                                        <a href="sanpham.php?id_category=' . $item['id'] . '">
                                            <p>' . $item['name'] . '</p>
                                            <div class="bg"></div>

                                        </a>
                                    </div>
                                    ';
                    }
                    ?>
                </div>
            </section>
                <div class="product-restaurants">
                    <div class="row">
                        <?php
                        try {
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $limit = 12;
                            $start = ($page - 1) * $limit;
                            $sql = "SELECT * FROM product limit $start,$limit";
                            executeResult($sql);
                            // $sql = 'select * from product limit $star,$limit';
                            $productList = executeResult($sql);

                            $index = 1;
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
                                                
                                                <span> Mới</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                            }
                        } catch (Exception $e) {
                            die("Lỗi thực thi sql: " . $e->getMessage());
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        
                    </div>
                </div>
            </section>
        </section>
    </div>
</main>
<?php require_once('layout/footer.php'); ?>
<script>
    $(document).ready(function() {
    updateCartInfo();
});

</script>
</div>
</body>

</html>
