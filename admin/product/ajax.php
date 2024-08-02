<?php
require_once('../database/dbhelper.php');

if (!empty($_POST)) {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'delete':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    
                    // Xóa các bản ghi liên quan trong bảng order_details
                    $sql = 'DELETE FROM order_details WHERE product_id = ' . $id;
                    execute($sql);

                    // Xóa sản phẩm
                    $sql = 'DELETE FROM product WHERE id = ' . $id;
                    execute($sql);
                }
                break;
        }
    }
}
?>
