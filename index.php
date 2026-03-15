<?php
session_start();
if(isset($_COOKIE['username'])){
    header("Location: catalog/login.php");
    exit();
}
// Nếu không có cookie, chuyển đến trang chính (catalog)
header("Location: catalog");
?>