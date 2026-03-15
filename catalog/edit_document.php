<?php
include 'header.php';
require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Kiểm tra id
if (!isset($_GET['id'])) {
    header('Location: document.php');
    exit();
}

$id = $_GET['id'];

// Lấy thông tin document
$sql = "SELECT * FROM document_links WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: document.php');
    exit();
}

$document = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $sql = "UPDATE document_links SET name=?, url=?, icon=?, description=?, category=? WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $url, $icon, $description, $category, $id);
    
    if ($stmt->execute()) {
        header('Location: document.php?msg=Cập nhật thành công');
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
            <i class="fas fa-edit me-2"></i>Chỉnh sửa liên kết tài liệu
        </h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên liên kết</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($document['name']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="url" class="form-control" name="url" value="<?= htmlspecialchars($document['url']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon</label>
                <select class="form-control" name="icon" required>
                    <option value="fab fa-google-drive"
                        <?= $document['icon'] == 'fab fa-google-drive' ? 'selected' : '' ?>>
                        Google Drive
                    </option>
                    <option value="fab fa-dropbox" <?= $document['icon'] == 'fab fa-dropbox' ? 'selected' : '' ?>>
                        Dropbox
                    </option>
                    <option value="fab fa-github" <?= $document['icon'] == 'fab fa-github' ? 'selected' : '' ?>>
                        GitHub
                    </option>
                    <option value="fas fa-cloud" <?= $document['icon'] == 'fas fa-cloud' ? 'selected' : '' ?>>
                        Cloud Storage
                    </option>
                    <option value="fas fa-link" <?= $document['icon'] == 'fas fa-link' ? 'selected' : '' ?>>
                        Other Link
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description"
                    rows="2"><?= htmlspecialchars($document['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <input type="text" class="form-control" name="category"
                    value="<?= htmlspecialchars($document['category']) ?>" list="categories"
                    placeholder="Chọn hoặc nhập mới">
                <datalist id="categories">
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['category']) ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>

            <div class="text-end">
                <a href="document.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>