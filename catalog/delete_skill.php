<?php
session_start();
include 'header.php';
require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kiểm tra xem skill có tồn tại không
    $check_sql = "SELECT id FROM skills WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Thực hiện xóa
        $sql = "DELETE FROM skills WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Đã xóa kỹ năng thành công";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa kỹ năng: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Không tìm thấy kỹ năng này";
    }
} else {
    $_SESSION['error'] = "Không có ID được cung cấp";
}

header("Location: skill.php");
exit();
?>