<?php
try{
    $pdo = new PDO("mysql:host=localhost;dbname=", "root", "");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
 
// Attempt select query execution
try{
    $sql = "SELECT * FROM persons ORDER BY first_name";
    $result = $pdo->query($sql);
    if($result->rowCount() > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>STT</th>";
                echo "<th>Tên</th>";
                echo "<th>Tên sản phẩm/Số lượng</th>";
                echo "<th>Giá sản phẩm</th>";
                echo "<th>Địa chỉ</th>";
                echo "<th>Số điện thoại</th>";
            echo "</tr>";
        while($row = $result->fetch()){
            echo "<tr>";
                echo "<td>" . $row['stt'] . "</td>";
                echo "<td>" . $row['ten'] . "</td>";
                echo "<td>" . $row['tensanpham/soluong'] . "</td>";
                echo "<td>" . $row['giasanpham'] . "</td>";
                echo "<td>" . $row['diachi'] . "</td>";
                echo "<td>" . $row['sodienthoai'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        unset($result);
    } else{
        echo "No records matching your query were found.";
    }
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
 
// Close connection
unset($pdo);
?>