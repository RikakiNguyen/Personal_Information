<?php
include 'config.php';

$password = "Hai2004@";
$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE username = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed);

if($stmt->execute()) {
    echo "Đã cập nhật mật khẩu thành công!";
    echo "<br>Mật khẩu đã hash: " . $hashed;
} else {
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn->close();
?>