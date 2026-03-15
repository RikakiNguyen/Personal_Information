<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Get list of document links
$sql = "SELECT * FROM document_links ORDER BY category, name";
$result = $conn->query($sql);
$documents = $result->fetch_all(MYSQLI_ASSOC);

// Group documents by category
$grouped_docs = [];
foreach ($documents as $doc) {
   $category = $doc['category'] ?: 'Khác';
   $grouped_docs[$category][] = $doc;
}
?>

<style>
.doc-card {
    transition: transform 0.2s ease-in-out;
}

.doc-card:hover {
    transform: translateY(-5px);
}

.doc-icon {
    font-size: 2rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
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
            <i class="fas fa-folder-open me-2"></i>Tài liệu
        </h5>
        <?php if ($canEdit): ?>
        <a href="add_document.php" class="btn btn-info btn-sm">
            <i class="fas fa-plus me-1"></i>Thêm liên kết mới
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($documents): ?>
        <?php foreach ($grouped_docs as $category => $docs): ?>
        <h5 class="mb-3 mt-4">
            <i class="fas fa-bookmark me-2"></i><?= htmlspecialchars($category) ?>
        </h5>
        <div class="row g-4">
            <?php foreach ($docs as $doc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 doc-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="doc-icon bg-<?= getIconBgClass($doc['icon']) ?> text-white me-3">
                                <i class="<?= htmlspecialchars($doc['icon']) ?>"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1"><?= htmlspecialchars($doc['name']) ?></h5>
                                <?php if ($doc['description']): ?>
                                <p class="text-muted small mb-0">
                                    <?= htmlspecialchars($doc['description']) ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= htmlspecialchars($doc['url']) ?>" class="btn btn-primary btn-sm"
                                target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i>Truy cập
                            </a>
                            <?php if ($canEdit): ?>
                            <div>
                                <a href="edit_document.php?id=<?= $doc['id'] ?>"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteDocument(<?= $doc['id'] ?>)"
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">Chưa có liên kết tài liệu nào</p>
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
function getIconBgClass($icon) {
   // Map icon to background color
   $icon_colors = [
       'fab fa-google-drive' => 'warning',
       'fab fa-dropbox' => 'primary', 
       'fab fa-github' => 'dark',
       'fas fa-link' => 'info',
       'fas fa-cloud' => 'success'
   ];
   
   return $icon_colors[$icon] ?? 'secondary';
}
?>

<?php if ($canEdit): ?>
<script>
function deleteDocument(id) {
    if (confirm('Bạn có chắc muốn xóa liên kết này?')) {
        window.location.href = `delete_document.php?id=${id}`;
    }
}
</script>
<?php endif; ?>