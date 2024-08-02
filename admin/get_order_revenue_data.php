<?php
require_once('database/dbhelper.php');

header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Truy vấn dữ liệu doanh thu và đơn hàng theo tháng
$sql = "
    SELECT 
        DATE_FORMAT(order_date, '%Y-%m') AS month,
        COUNT(*) AS order_count,
        SUM(order_details.num * product.price) AS revenue
    FROM orders
    JOIN order_details ON orders.id = order_details.order_id
    JOIN product ON product.id = order_details.product_id
    GROUP BY month
    ORDER BY month
";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
mysqli_close($conn);
?>
