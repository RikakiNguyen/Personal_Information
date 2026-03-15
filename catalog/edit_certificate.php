<?php
include 'header.php';
require_once 'auth.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM certificates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$certificate = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $issue_date = $_POST['issue_date'];
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    $credential_id = $_POST['credential_id'];

    $sql = "UPDATE certificates SET title=?, organization=?, issue_date=?, expiry_date=?, credential_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $organization, $issue_date, $expiry_date, $credential_id, $id);

    if ($stmt->execute()) {
        header('Location: certificate.php');
        exit();
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Chỉnh sửa chứng chỉ</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên chứng chỉ</label>
                <input type="text" class="form-control" name="title"
                    value="<?= htmlspecialchars($certificate['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tổ chức cấp</label>
                <input type="text" class="form-control" name="organization"
                    value="<?= htmlspecialchars($certificate['organization']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày cấp</label>
                <input type="date" class="form-control" name="issue_date" value="<?= $certificate['issue_date'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày hết hạn (không bắt buộc)</label>
                <input type="date" class="form-control" name="expiry_date" value="<?= $certificate['expiry_date'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mã chứng chỉ</label>
                <input type="text" class="form-control" name="credential_id"
                    value="<?= htmlspecialchars($certificate['credential_id']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="certificate.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>