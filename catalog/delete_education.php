<?php
session_start();
include '../config.php';
require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Kiểm tra xem có id được truyền vào không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kiểm tra xem id có tồn tại không
    $check_sql = "SELECT id FROM education WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Thực hiện xóa
        $sql = "DELETE FROM education WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Đã xóa thông tin học vấn thành công";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa thông tin: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Không tìm thấy thông tin học vấn này";
    }
} else {
    $_SESSION['error'] = "Không có ID được cung cấp";
}

header('Location: education.php');
exit();
?>