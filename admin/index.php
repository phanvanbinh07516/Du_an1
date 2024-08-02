<?php require_once('database/dbhelper.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Bảng Thống Kê</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- <link rel="stylesheet" href=".admin/style.css"> -->
</head>

<body>
    <div id="wrapper">
        <header class="vertical-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="../index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category/index.php">Quản lý danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="dashboard.php">Quản lý đơn hàng</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="client/">Quản lý khách hàng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <main>
                <h1>Bảng thống kê</h1>
                <section class="dashboard">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Sản phẩm</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php
                                        $sql = "SELECT COUNT(*) as total FROM `product`";
                                        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo '<span>' . $row['total'] . '</span>';
                                        ?>
                                    </p>
                                    <p><a href="product/">xem chi tiết➜</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Khách hàng</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php
                                        $sql = "SELECT COUNT(*) as total FROM `user`";
                                        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo '<span>' . $row['total'] . '</span>';
                                        ?>
                                    </p>
                                    <p><a href="client/">xem chi tiết➜</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Danh mục</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php
                                        $sql = "SELECT COUNT(*) as total FROM `category`";
                                        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo '<span>' . $row['total'] . '</span>';
                                        ?>
                                    </p>
                                    <p><a href="category/">xem chi tiết➜</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Đơn hàng</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php
                                        $sql = "SELECT COUNT(*) as total FROM `order_details`";
                                        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo '<span>' . $row['total'] . '</span>';
                                        ?>
                                    </p>
                                    <p><a href="dashboard.php">xem chi tiết➜</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Doanh thu và Đơn hàng theo tháng</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="revenueOrderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            
            </main>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $.ajax({
            url: 'get_order_revenue_data.php', // Đường dẫn đến tệp PHP của bạn
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var months = [];
                var revenues = [];
                var orderCounts = [];

                // Phân tích dữ liệu trả về từ PHP
                data.forEach(function(item) {
                    months.push('Tháng ' + item.month);
                    revenues.push(item.revenue);
                    orderCounts.push(item.order_count);
                });

                var ctx = document.getElementById('revenueOrderChart').getContext('2d');
                var revenueOrderChart = new Chart(ctx, {
                    type: 'bar', // Thay đổi từ 'line' thành 'bar'
                    data: {
                        labels: months, // Tháng
                        datasets: [{
                            label: 'Doanh thu',
                            data: revenues, // Doanh thu
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Số lượng đơn hàng',
                            data: orderCounts, // Số lượng đơn hàng
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true  // Bắt đầu từ 0 trên trục Y
                            }
                        }
                    }
                });
            },
            error: function() {
                console.error('Không thể tải dữ liệu doanh thu.');
            }
        });
    });
    </script>
</body>



<style>
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
        margin-left: 220px; /* Adjust based on the width of the vertical nav */
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
</style>

</html>
