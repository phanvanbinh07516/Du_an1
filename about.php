<?php require('layout/header.php') ?>
<style>
    main {
        font-family: "Encode Sans SC", sans-serif;
    }

    .row img {
        max-width: 100%;
    }
</style>
<main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <div class="container">
        <div id="ant-layout">
            <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="thucdon.php" method="GET">
                    <input name="search" type="text" placeholder="Tìm sản phẩm">
                </form>
            </section>
            <section class="main">
                <div class="row">
                    <h3>Cửa hàng quần áo nam của chúng tôi là gì?</h3>
                    <p>Chúng tôi hiểu rằng một bộ trang phục đẹp không chỉ nâng cao vẻ ngoài mà còn giúp bạn tự tin hơn trong mọi tình huống. Với sự ra mắt cửa hàng quần áo nam, chúng tôi mang đến cho bạn những sản phẩm chất lượng từ các thương hiệu nổi tiếng, đáp ứng mọi nhu cầu thời trang của bạn.</p>
                </div>
                <div class="row">
                    <h3>Cửa hàng chúng tôi hoạt động như thế nào?</h3>
                    <p>Cửa hàng hoạt động từ 8h đến 21h hằng ngày, giúp bạn có thể thoải mái lựa chọn và mua sắm bất cứ khi nào.</p>
                </div>
                <div class="row">
                    <img src="images/bg/MensClothing.jpg" alt="">

                    <h3>Những thương hiệu quần áo nào có mặt tại cửa hàng của chúng tôi?</h3>
                    <p>Chúng tôi cung cấp sản phẩm từ nhiều thương hiệu nổi tiếng như Nike, Adidas, Levi's, và nhiều hơn nữa. Bạn có thể tìm thấy đa dạng các loại trang phục từ quần jean, áo sơ mi đến áo khoác và phụ kiện thời trang.</p>
                </div>
                <div class="row">
                    <h3>Tôi có thể thanh toán bằng tiền mặt không?</h3>
                    <p>Có nhé!</p>
                </div>
                <div class="row">
                    <h3>Tôi có thể thanh toán bằng thẻ tín dụng hoặc thẻ ghi nợ không?</h3>
                    <p>Chúng tôi chấp nhận thanh toán bằng thẻ tín dụng và thẻ ghi nợ. Hãy an tâm mua sắm mà không lo lắng về phương thức thanh toán.</p>
                </div>
                <div class="row">
                    <h3>Chi phí được tính như thế nào?</h3>
                    <p>Chi phí hiển thị trên trang web bao gồm giá sản phẩm và phí vận chuyển (nếu có).</p>
                </div>
                <div class="row">
                    <h3>Tôi có thể tìm thấy những loại trang phục nào tại cửa hàng?</h3>
                    <p>Chúng tôi cung cấp đa dạng các loại trang phục như quần tây, quần jean, áo sơ mi, áo thun, áo khoác, và phụ kiện thời trang như mũ, ví, dây nịt.</p>
                </div>
                <div class="row">
                    <h3>Tôi có thể tìm thấy những cửa hàng nào gần khu vực của mình?</h3>
                    <p>Danh sách các cửa hàng của chúng tôi được sắp xếp dựa theo khoảng cách và thời gian giao hàng dự kiến từ địa chỉ giao hàng đến vị trí của bạn.</p>
                </div>
                
            </section>
        </div>
    </div>
</main>
<?php require('layout/footer.php') ?>
