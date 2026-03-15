<?php
include 'header.php';
require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);

    // Validate
    $errors = [];
    if (empty($name)) {
        $errors[] = "Tên kỹ năng không được để trống";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO skills (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        
        if ($stmt->execute()) {
            header("Location: skill.php?msg=Thêm kỹ năng thành công");
            exit();
        } else {
            $errors[] = "Có lỗi xảy ra: " . $conn->error;
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm kỹ năng
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tên kỹ năng</label>
                <input type="text" class="form-control" name="name"
                    value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
            </div>

            <div class="text-end">
                <a href="skill.php" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu kỹ năng</button>
            </div>
        </form>
    </div>
</div>