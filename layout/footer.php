<footer>
  <div class="container">
    <div class="logo">
      <a href=""><h2>KENTA.vn</h2></a>
    </div>
    <div class="link">
      <div class="col">
        <h4>KENTA VN</h4>
        <a href="">Giới thiệu</a>
        <a href="">Kiểm tra đơn hàng</a>
        <a href="">Cách chọn size</a>
        <a href="">Thông tin liên hệ</a>
        <a href="">Câu hỏi thường gặp</a>
        <a href="">Hướng dẫn bảo quản</a>
      </div>
      <div class="col">
        <h4>CHÍNH SÁCH</h4>
        <a href="">Hướng dẫn mua hàng</a>
        <a href="">Khách hàng thân thiết</a>
        <a href="">Chính sách đổi hàng</a>
        <a href="">Chính sách bảo mật</a>
        <a href="">Đối tác sản xuất</a>
        <a href="">Bán hàng liên kết (Affiliate)</a>
      </div>
      <div class="col">
        <h4>KẾT NỐI VỚI KENTA</h4>
        <div class="social-icons">
          <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram-square"></i></a>
          <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </div>
      </div>
      <div class="col">
        <h4>THÔNG TIN CỬA HÀNG</h4>
        <p>20 Cửu Long, P15, Q.10, HCM</p>
        <p>168 Nguyễn Trọng Tuyển, P8, Phú Nhuận</p>
        <p>Hotline: (028) 7300 6200</p>
        <p>Mail: kentasale@gmail.com</p>
        <div class="store-links">
          <a href=""><img src="images/icon/logo-playstore.svg" alt=""></a>
          <a href=""><img src="images/icon/logo-appstore.svg" alt=""></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<style>
  footer {
    background-color: dimgray;  
    width: 100%;
    margin: 0px auto;
    margin-top: 1rem;
  }
  footer .container {
    width: 90%;
    margin: 0px auto;
    display: flex;
    flex-flow: column;
  }
  footer .container .logo {
    padding: 10px 0;
    border-bottom: 1px solid white;
    display: flex;
    justify-content: center;
  }
  footer .container .link {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 30px 0;
    border-bottom: 1px solid white;
  }
  footer .container .link .col a:hover {
    cursor: pointer;
    color: rgb(224, 247, 222);
  }
  footer .container .link .col a {
    color: white;
    font-weight: bold;
    text-decoration: none;
    padding: 10px 0;
    font-family: "Encode Sans SC", sans-serif;
  }
  footer .container .link .col h4 {
    color: white;
    font-weight: bold;
    margin-bottom: 10px;
    font-family: "Encode Sans SC", sans-serif;
  }
  footer .container .link .col p {
    color: white;
    margin: 5px 0;
    /* font-family: "Encode Sans SC"; */
  }
  footer .container .link .icon a {
    padding: 10px 10px;
    color: white;
    font-weight: bold;
    text-decoration: none;
  }
  footer .container .link .icon a i {
    font-size: 40px;
  }
  footer .container .link .col {
    display: flex;
    flex-flow: column;
  }
  footer .container .link .icon {
    display: flex;
  }
  footer .container .social-icons {
    display: flex;
    gap: 10px;
  }
  footer .container .store-links {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }
  footer .container .bottom {
    padding: 20px 0;
    display: flex;
    justify-content: center;
  }
  footer .container .bottom a {
    margin: 0 10px;
  }
</style>
