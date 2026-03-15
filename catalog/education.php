<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Lấy danh sách học vấn
$sql = "SELECT * FROM education ORDER BY end_year DESC";
$result = $conn->query($sql);
$education = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-graduation-cap me-2"></i>Học vấn
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_education.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($education): ?>
        <?php foreach ($education as $edu): ?>
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($edu['school']) ?></h5>
                    <p class="text-muted mb-1"><?= htmlspecialchars($edu['degree']) ?></p>
                    <div class="small text-muted">
                        <?= $edu['start_year'] ?> - <?= $edu['end_year'] ?>
                        <span class="ms-2">GPA: <?= number_format($edu['gpa'], 1) ?>/4.0</span>
                    </div>
                </div>
                <?php if ($canEdit): ?>
                <div>
                    <a href="edit_education.php?id=<?= $edu['id'] ?>" class="btn btn-sm btn-primary me-1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteEducation(<?= $edu['id'] ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted">Chưa có thông tin học vấn</p>
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
function deleteEducation(id) {
    if (confirm('Bạn có chắc muốn xóa thông tin học vấn này?')) {
        window.location.href = `delete_education.php?id=${id}`;
    }
}
</script>
<?php endif; ?>