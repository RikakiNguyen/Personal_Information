<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of experiences ordered by start date
$sql = "SELECT * FROM experience ORDER BY start_date DESC";
$result = $conn->query($sql);
$experiences = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-briefcase me-2"></i>Kinh nghiệm làm việc
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_experience.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($experiences): ?>
        <?php foreach ($experiences as $exp): ?>
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($exp['company']) ?></h5>
                    <p class="text-muted mb-1"><?= htmlspecialchars($exp['position']) ?></p>
                    <div class="small text-muted">
                        <?= date('m/Y', strtotime($exp['start_date'])) ?> -
                        <?= $exp['is_current'] ? 'Hiện tại' : date('m/Y', strtotime($exp['end_date'])) ?>
                    </div>
                    <div class="mt-2">
                        <?= nl2br(htmlspecialchars($exp['responsibilities'])) ?>
                    </div>
                </div>
                <?php if ($canEdit): ?>
                <div>
                    <a href="edit_experience.php?id=<?= $exp['id'] ?>" class="btn btn-sm btn-primary me-1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteExperience(<?= $exp['id'] ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted">Chưa có thông tin kinh nghiệm làm việc</p>
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
function deleteExperience(id) {
    if (confirm('Bạn có chắc muốn xóa thông tin kinh nghiệm này?')) {
        window.location.href = `delete_experience.php?id=${id}`;
    }
}
</script>
<?php endif; ?>