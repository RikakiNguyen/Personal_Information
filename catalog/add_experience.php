<?php
include 'header.php';

require_once 'auth.php';

// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = $_POST['company'];
    $position = $_POST['position'];
    $start_date = $_POST['start_date'];
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $end_date = $is_current ? NULL : $_POST['end_date'];
    $responsibilities = $_POST['responsibilities'];

    $sql = "INSERT INTO experience (company, position, start_date, end_date, is_current, responsibilities) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $company, $position, $start_date, $end_date, $is_current, $responsibilities);
    
    if ($stmt->execute()) {
        header("Location: experience.php");
        exit();
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm kinh nghiệm làm việc
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Công ty</label>
                <input type="text" class="form-control" name="company" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Vị trí</label>
                <input type="text" class="form-control" name="position" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" required>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_current" id="is_current">
                    <label class="form-check-label" for="is_current">
                        Đang làm việc tại đây
                    </label>
                </div>
            </div>

            <div class="mb-3" id="end_date_div">
                <label class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date">
            </div>

            <div class="mb-3">
                <label class="form-label">Trách nhiệm công việc</label>
                <textarea class="form-control" name="responsibilities" rows="4"></textarea>
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