<?php 
include 'header.php';
require_once 'auth.php';

$canEdit = isLoggedIn();

// Lấy thông tin cá nhân
$sql = "SELECT * FROM personal_info WHERE id = 1";
$result = $conn->query($sql);
$info = $result->fetch_assoc();
?>

<!-- Thông tin chi tiết -->
<div class="card">
    <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-user me-2"></i>Thông tin cá nhân
        </h5>
        <?php if ($canEdit): ?>
        <a href="edit_info.php" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>Chỉnh sửa
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <strong>Họ và tên:</strong>
                    <span class="ms-2"><?= htmlspecialchars($info['name']) ?></span>
                </div>
                <div class="mb-3">
                    <strong>Nghề nghiệp:</strong>
                    <span class="ms-2"><?= htmlspecialchars($info['title']) ?></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <span class="ms-2"><?= htmlspecialchars($info['email']) ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <strong>Số điện thoại:</strong>
                    <span class="ms-2"><?= htmlspecialchars($info['phone']) ?></span>
                </div>
                <div class="mb-3">
                    <strong>Địa chỉ:</strong>
                    <span class="ms-2"><?= htmlspecialchars($info['location']) ?></span>
                </div>
                <div class="mb-3">
                    <strong>Ngày sinh:</strong>
                    <span class="ms-2"><?= date('d/m/Y', strtotime($info['dob'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>