<?php
function getPost($key) {
    return isset($_POST[$key]) ? $_POST[$key] : '';
}
?>
