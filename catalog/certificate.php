<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of certificates ordered by issue date
$sql = "SELECT * FROM certificates ORDER BY issue_date DESC";
$result = $conn->query($sql);
$certificates = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-certificate me-2"></i>Chứng chỉ
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_certificate.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($certificates): ?>
        <?php foreach ($certificates as $certificate): ?>
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($certificate['title']) ?></h5>
                    <p class="text-muted mb-1"><?= htmlspecialchars($certificate['organization']) ?></p>
                    <div class="small text-muted">
                        Ngày cấp: <?= date('d/m/Y', strtotime($certificate['issue_date'])) ?>
                        <?php if ($certificate['expiry_date']): ?>
                        <br>Ngày hết hạn: <?= date('d/m/Y', strtotime($certificate['expiry_date'])) ?>
                        <?php endif; ?>
                        <?php if ($certificate['credential_id']): ?>
                        <br>Mã chứng chỉ: <?= htmlspecialchars($certificate['credential_id']) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($canEdit): ?>
                <div>
                    <a href="edit_certificate.php?id=<?= $certificate['id'] ?>" class="btn btn-sm btn-primary me-1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteCertificate(<?= $certificate['id'] ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted text-center">Chưa có thông tin chứng chỉ</p>
        <?php endif; ?>
    </div>
</div>

<!-- Auth Button -->
<div class="auth-button">
    <?php if ($canEdit): ?>
    <a href="logout.php" class="btn btn-outline-danger">
        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
    </a>
    <?php else: ?>
    <a href="login.php" class="btn btn-outline-primary">
        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
    </a>
    <?php endif; ?>
</div>

<?php if ($canEdit): ?>
<script>
function deleteCertificate(id) {
    if (confirm('Bạn có chắc muốn xóa thông tin chứng chỉ này?')) {
        window.location.href = `delete_certificate.php?id=${id}`;
    }
}
</script>
<?php endif; ?>