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
    
    // Get project image before deleting
    $sql = "SELECT image FROM projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
    
    // Delete project image if exists
    if ($project['image'] && file_exists("uploads/projects/" . $project['image'])) {
        unlink("uploads/projects/" . $project['image']);
    }
    
    // Delete project record
    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Đã xóa dự án thành công";
        header("Location: project.php");
        exit();
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra khi xóa dự án";
    }
}

header("Location: project.php");
exit();
?>