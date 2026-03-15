<?php
include 'header.php';
require_once 'auth.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $issue_date = $_POST['issue_date'];
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    $credential_id = $_POST['credential_id'];

    $sql = "INSERT INTO certificates (title, organization, issue_date, expiry_date, credential_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $organization, $issue_date, $expiry_date, $credential_id);

    if ($stmt->execute()) {
        header('Location: certificate.php');
        exit();
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Thêm chứng chỉ mới</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên chứng chỉ</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tổ chức cấp</label>
                <input type="text" class="form-control" name="organization" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày cấp</label>
                <input type="date" class="form-control" name="issue_date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày hết hạn (không bắt buộc)</label>
                <input type="date" class="form-control" name="expiry_date">
            </div>
            <div class="mb-3">
                <label class="form-label">Mã chứng chỉ</label>
                <input type="text" class="form-control" name="credential_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="certificate.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>