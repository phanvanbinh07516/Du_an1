<?php require "layout/header.php"; ?>
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
require_once('utils/utility.php');
// Lấy id từ trang index.php truyền sang rồi hiển thị nó
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'select * from product where id=' . $id;
    $product = executeSingleResult($sql);
    // Kiểm tra nếu ko có id sp đó thì trả về index.php
    if ($product == null) {
        header('Location: index.php');
        die();
    }
}
?>
<style>
    
</style>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0&appId=264339598396676&autoLogAppEvents=1" nonce="8sTfFiF4"></script>
<!-- END HEADR -->
<main>
    <div class="container">
        <div id="ant-layout">
        <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="thucdon.php" method="GET">
                    <input name="search" type="text" placeholder="Tìm món hoặc thức ăn">
                </form>
            </section>
        </div>
        <!-- <div class="bg-grey">
        </div> -->
        <!-- END LAYOUT  -->
        <section class="main">
            <section class="oder-product">
                <div class="title">
                    <section class="main-order">
                        <h1><?= $product['title'] ?></h1>
                        <div class="box">
                            <img src="<?='admin/product/'.$product['thumbnail'] ?>" alt="">
                            <div class="about">
                                <p><?= $product['content'] ?></p>
                                <div class="size">
                                    <p>Size:</p>
                                    <ul>
                                        <li><a href="">S</a></li>
                                        <li><a href="">M</a></li>
                                        <li><a href="">L</a></li>
                                    </ul>
                                </div>
                                <div class="number">
                                    <span class="number-buy">Số lượng</span>
                                    <input id="num" type="number" value="1" min="1" onchange="updatePrice()">
                                </div>

                                <p class="price">Giá: <span id="price"><?= number_format($product['price'], 0, ',', '.') ?></span><span> VNĐ</span><span class="gia none"><?= $product['price'] ?></span></p>
                                <!-- <a class="add-cart" href="" onclick="addToCart(<?= $id ?>)"><i class="fas fa-cart-plus"></i>Thêm vào giỏ hàng</a> -->
                                <button class="add-cart" onclick="addToCart(<?= $id ?>)"><i class="fas fa-cart-plus"></i>Thêm vào giỏ hàng</button>
                                <!-- <a class="buy-now" href="checkout.php" >Mua ngay</a> -->
                                <button class="buy-now" onclick="buyNow(<?= $id ?>)">Mua ngay</button>

                                <script>
                                    function updatePrice() {
                                        var price = document.getElementById('price').innerText; // giá tiền
                                        var num = document.querySelector('#num').value; // số lượng
                                        var gia1 = document.querySelector('.gia').innerText;
                                        var gia = price.match(/\d/g);
                                        gia = gia.join("");
                                        var tong = gia1 * num;
                                        document.getElementById('price').innerHTML = tong.toLocaleString();
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="fb-comments" data-href="http://localhost/PROJECT/details.php" data-width="750" data-numposts="5"></div>

                    </section>
                </div>
                <aside>
                    <h1>Gợi ý cho bạn</h1>
                    <div class="row">
                        <?php
                        $sql = 'select * from product limit 5';
                        $productList = executeResult($sql);
                        $index = 1;
                        foreach ($productList as $item) {
                            echo '
                                    <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img src="admin/product/'.$item['thumbnail'] . '" alt="">
                                        <div class="about">
                                            <div class="title">
                                                <p>' . $item['title'] . '</p>
                                                <span>Giá: ' . number_format($product['price'], 0, ',', '.') . ' VNĐ' . '</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </aside>
            </section>
            
    </div>
</main>
<?php require_once('layout/footer.php'); ?>
</div>
<script type="text/javascript">
function addToCart(id) {
    var quantity = document.querySelector('#num').value;
    $.post('api/cookie.php', {
        'action': 'add',
        'id': id,
        'quantity': quantity
    }, function(data) {
        if (data.success) {
            updateCartInfo();
            window.location.reload();
        } else {
            alert('Thêm sản phẩm vào giỏ hàng thất bại!');
        }
    }, 'json');
}

function buyNow(id) {
    var quantity = document.querySelector('#num').value;
    $.post('api/cookie.php', {
        'action': 'buy',
        'id': id,
        'quantity': quantity
    }, function(data) {
        if (data.success) {
            window.location.href = data.redirect; // Chuyển hướng đến trang thanh toán
        } else {
            alert('Mua ngay thất bại!');
        }
    }, 'json');
}

function updateCartInfo() {
    $.get('api/cookie.php', { 'action': 'getCartInfo' }, function(data) {
        $('#cart-count').text(data.count);
    }, 'json');
}


</script>
</body>

</html>