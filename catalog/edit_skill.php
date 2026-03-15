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
    header('Location: skill.php');
    exit();
}

$id = $_GET['id'];

// Lấy thông tin kỹ năng
$sql = "SELECT * FROM skills WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: skill.php');
    exit();
}

$skill = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);

    // Validate
    $errors = [];
    if (empty($name)) {
        $errors[] = "Tên kỹ năng không được để trống";
    }

    if (empty($errors)) {
        $sql = "UPDATE skills SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        
        if ($stmt->execute()) {
            header("Location: skill.php?msg=Cập nhật thành công");
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
            <i class="fas fa-edit me-2"></i>Chỉnh sửa kỹ năng
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
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($skill['name']) ?>"
                    required>
            </div>

            <div class="text-end">
                <a href="skill.php" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>