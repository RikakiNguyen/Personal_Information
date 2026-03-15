<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of achievements ordered by year
$sql = "SELECT * FROM achievements ORDER BY year DESC";
$result = $conn->query($sql);
$achievements = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-trophy me-2"></i>Thành tích
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_achievement.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($achievements): ?>
        <?php foreach ($achievements as $achievement): ?>
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($achievement['title']) ?></h5>
                    <p class="text-muted mb-1"><?= htmlspecialchars($achievement['organization']) ?></p>
                    <div class="small text-muted">
                        Năm: <?= $achievement['year'] ?>
                    </div>
                    <?php if (!empty($achievement['article_link'])): ?>
                    <div class="mt-2">
                        <a href="<?= htmlspecialchars($achievement['article_link']) ?>" target="_blank"
                            class="text-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Xem bài báo liên quan
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if ($canEdit): ?>
                <div>
                    <a href="edit_achievement.php?id=<?= $achievement['id'] ?>" class="btn btn-sm btn-primary me-1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteAchievement(<?= $achievement['id'] ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted">Chưa có thông tin thành tích</p>
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
function deleteAchievement(id) {
    if (confirm('Bạn có chắc muốn xóa thông tin thành tích này?')) {
        window.location.href = `delete_achievement.php?id=${id}`;
    }
}
</script>
<?php endif; ?>