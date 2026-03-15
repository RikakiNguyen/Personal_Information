<?php
include 'header.php';
require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $sql = "INSERT INTO document_links (name, url, icon, description, category) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $url, $icon, $description, $category);
    
    if ($stmt->execute()) {
        header('Location: document.php?msg=Thêm liên kết thành công');
        exit();
    } else {
        $error = "Có lỗi xảy ra: " . $conn->error;
    }
}

// Get existing categories
$sql = "SELECT DISTINCT category FROM document_links WHERE category IS NOT NULL";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm liên kết tài liệu
        </h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên liên kết</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="url" class="form-control" name="url" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon</label>
                <select class="form-control" name="icon" required>
                    <option value="fab fa-google-drive">Google Drive</option>
                    <option value="fab fa-dropbox">Dropbox</option>
                    <option value="fab fa-github">GitHub</option>
                    <option value="fas fa-cloud">Cloud Storage</option>
                    <option value="fas fa-link">Other Link</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <input type="text" class="form-control" name="category" list="categories"
                    placeholder="Chọn hoặc nhập mới">
                <datalist id="categories">
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['category']) ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>

            <div class="text-end">
                <a href="document.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>