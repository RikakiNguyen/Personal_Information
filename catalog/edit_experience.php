<?php
include 'header.php';

require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Kiểm tra id có tồn tại
if (!isset($_GET['id'])) {
    header('Location: experience.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM experience WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$exp = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = $_POST['company'];
    $position = $_POST['position'];
    $start_date = $_POST['start_date'];
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $end_date = $is_current ? NULL : $_POST['end_date'];
    $responsibilities = $_POST['responsibilities'];

    $sql = "UPDATE experience SET company=?, position=?, start_date=?, end_date=?, 
            is_current=?, responsibilities=? WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $company, $position, $start_date, $end_date, 
                      $is_current, $responsibilities, $id);
    
    if ($stmt->execute()) {
        header("Location: experience.php");
        exit();
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa kinh nghiệm làm việc
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Công ty</label>
                <input type="text" class="form-control" name="company" value="<?= htmlspecialchars($exp['company']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Vị trí</label>
                <input type="text" class="form-control" name="position"
                    value="<?= htmlspecialchars($exp['position']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" value="<?= $exp['start_date'] ?>" required>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_current" id="is_current"
                        <?= $exp['is_current'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_current">
                        Đang làm việc tại đây
                    </label>
                </div>
            </div>

            <div class="mb-3" id="end_date_div" style="display: <?= $exp['is_current'] ? 'none' : 'block' ?>">
                <label class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" value="<?= $exp['end_date'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Trách nhiệm công việc</label>
                <textarea class="form-control" name="responsibilities"
                    rows="4"><?= htmlspecialchars($exp['responsibilities']) ?></textarea>
            </div>

            <div class="text-end">
                <a href="experience.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('is_current').addEventListener('change', function() {
    document.getElementById('end_date_div').style.display = this.checked ? 'none' : 'block';
});
</script>