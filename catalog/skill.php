<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of skills
$sql = "SELECT * FROM skills ORDER BY name ASC";
$result = $conn->query($sql);
$skills = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-code me-2"></i>Kỹ năng
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_skill.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($skills): ?>
        <div class="row g-3">
            <?php foreach ($skills as $skill): ?>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span><?= htmlspecialchars($skill['name']) ?></span>
                    </div>
                    <?php if ($canEdit): ?>
                    <div>
                        <a href="edit_skill.php?id=<?= $skill['id'] ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="deleteSkill(<?= $skill['id'] ?>)" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-muted">Chưa có thông tin kỹ năng</p>
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
function deleteSkill(id) {
    if (confirm('Bạn có chắc muốn xóa kỹ năng này?')) {
        window.location.href = `delete_skill.php?id=${id}`;
    }
}
</script>
<?php endif; ?>