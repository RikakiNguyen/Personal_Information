<?php
include 'header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Xác nhận tài liệu tồn tại trước khi xóa
    $check_sql = "SELECT * FROM document_links WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Tiến hành xóa
        $sql = "DELETE FROM document_links WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Xóa liên kết thành công!'); window.location.href='document.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi xóa!'); window.location.href='document.php';</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy liên kết!'); window.location.href='document.php';</script>";
    }
} else {
    header("Location: document.php");
}
?>