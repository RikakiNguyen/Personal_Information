<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    
    // Kiểm tra file
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowed)) {
        echo "Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)";
        exit;
    }
    
    // Tạo tên file mới
    $newFileName = uniqid() . '.' . $fileExtension;
    $uploadPath = 'uploads/avatar/' . $newFileName;
    
    // Tạo thư mục nếu chưa có
    if (!file_exists('uploads/avatar')) {
        mkdir('uploads/avatar', 0777, true);
    }
    
    // Upload file
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        // Xóa avatar cũ nếu có
        $sql = "SELECT avatar FROM personal_info WHERE id = 1";
        $result = $conn->query($sql);
        $old_avatar = $result->fetch_assoc()['avatar'];
        
        if ($old_avatar && file_exists('uploads/avatar/' . $old_avatar)) {
            unlink('uploads/avatar/' . $old_avatar);
        }
        
        // Cập nhật database
        $sql = "UPDATE personal_info SET avatar = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $newFileName);
        
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Lỗi cập nhật database";
        }
    } else {
        echo "Lỗi upload file";
    }
}
?>