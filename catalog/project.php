<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of projects ordered by start date
$sql = "SELECT * FROM projects ORDER BY start_date DESC";
$result = $conn->query($sql);
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<style>
.project-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.card-img-top {
    transition: transform 0.3s ease-in-out;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.card {
    overflow: hidden;
}

.auth-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.auth-button .btn {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
</style>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-project-diagram me-2"></i>Dự án
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_project.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($projects): ?>
        <div class="row g-4">
            <?php foreach ($projects as $project): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 project-card">
                    <?php if ($project['image']): ?>
                    <img src="../uploads/projects/<?= htmlspecialchars($project['image']) ?>" class="card-img-top"
                        alt="<?= htmlspecialchars($project['name']) ?>" style="height: 200px; object-fit: cover;"
                        loading="lazy">
                    <?php else: ?>
                    <div class="text-center p-4 bg-light">
                        <i class="fas fa-image fa-3x text-muted"></i>
                        <p class="text-muted mt-2">Chưa có ảnh</p>
                    </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($project['name']) ?></h5>
                            <span class="badge bg-<?= getStatusBadgeClass($project['status']) ?>">
                                <?= getStatusLabel($project['status']) ?>
                            </span>
                        </div>

                        <p class="card-text"><?= nl2br(htmlspecialchars($project['description'])) ?></p>

                        <div class="mb-3">
                            <strong><i class="fas fa-code me-1"></i>Công nghệ:</strong><br>
                            <div class="mt-1">
                                <?php foreach (explode(',', $project['technologies']) as $tech): ?>
                                <span class="badge bg-secondary me-1 mb-1">
                                    <?= trim($tech) ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="text-muted small mb-2">
                            <i class="fas fa-calendar me-1"></i>
                            <?= date('m/Y', strtotime($project['start_date'])) ?> -
                            <?= $project['end_date'] ? date('m/Y', strtotime($project['end_date'])) : 'Hiện tại' ?>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small mb-1">
                                <i class="fas fa-user me-1"></i>Vai trò: <?= htmlspecialchars($project['role']) ?>
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-users me-1"></i>Team size: <?= $project['team_size'] ?>
                            </div>
                        </div>

                        <?php if ($project['challenges'] || $project['results']): ?>
                        <div class="mt-3">
                            <?php if ($project['challenges']): ?>
                            <div class="mb-2">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i>Thách thức:</strong>
                                <p class="text-muted small mb-1"><?= nl2br(htmlspecialchars($project['challenges'])) ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($project['results']): ?>
                            <div>
                                <strong><i class="fas fa-check-circle me-1"></i>Kết quả:</strong>
                                <p class="text-muted small mb-0"><?= nl2br(htmlspecialchars($project['results'])) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex gap-2 mt-3">
                            <?php if ($project['github_link']): ?>
                            <a href="<?= htmlspecialchars($project['github_link']) ?>" class="btn btn-sm btn-dark"
                                target="_blank">
                                <i class="fab fa-github me-1"></i>Github
                            </a>
                            <?php endif; ?>

                            <?php if ($project['demo_link']): ?>
                            <a href="<?= htmlspecialchars($project['demo_link']) ?>" class="btn btn-sm btn-primary"
                                target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i>Demo
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($canEdit): ?>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="edit_project.php?id=<?= $project['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteProject(<?= $project['id'] ?>)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
            <p class="text-muted">Chưa có thông tin dự án</p>
        </div>
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

<?php
function getStatusBadgeClass($status) {
   switch ($status) {
       case 'planning':
           return 'secondary';
       case 'in_progress':
           return 'primary';
       case 'completed':
           return 'success';
       case 'on_hold':
           return 'warning';
       default:
           return 'secondary';
   }
}

function getStatusLabel($status) {
   switch ($status) {
       case 'planning':
           return 'Lên kế hoạch';
       case 'in_progress':
           return 'Đang thực hiện';
       case 'completed':
           return 'Hoàn thành';
       case 'on_hold':
           return 'Tạm dừng';
       default:
           return 'Không xác định';
   }
}
?>

<?php if ($canEdit): ?>
<script>
function deleteProject(id) {
    if (confirm('Bạn có chắc muốn xóa dự án này?')) {
        window.location.href = `delete_project.php?id=${id}`;
    }
}
</script>
<?php endif; ?>