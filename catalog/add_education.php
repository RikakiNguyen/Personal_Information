<?php
include 'header.php';

// Xử lý thêm mới khi submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $school = $_POST['school'];
   $degree = $_POST['degree'];
   $start_year = $_POST['start_year'];
   $end_year = $_POST['end_year'];
   $gpa = $_POST['gpa'];

   $sql = "INSERT INTO education (school, degree, start_year, end_year, gpa) 
           VALUES (?, ?, ?, ?, ?)";
           
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("ssiid", $school, $degree, $start_year, $end_year, $gpa);
   
   if ($stmt->execute()) {
       header("Location: education.php");
       exit();
   } else {
       $error = "Có lỗi xảy ra khi thêm thông tin";
   }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus me-2"></i>Thêm học vấn mới
        </h5>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="school" class="form-label">Tên trường</label>
                <input type="text" class="form-control" id="school" name="school" required>
            </div>

            <div class="mb-3">
                <label for="degree" class="form-label">Bằng cấp/Chuyên ngành</label>
                <input type="text" class="form-control" id="degree" name="degree" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_year" class="form-label">Năm bắt đầu</label>
                        <input type="number" class="form-control" id="start_year" name="start_year" required min="1900"
                            max="<?= date('Y') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_year" class="form-label">Năm kết thúc</label>
                        <input type="number" class="form-control" id="end_year" name="end_year" required min="1900"
                            max="<?= date('Y') ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="gpa" class="form-label">GPA</label>
                <input type="number" class="form-control" id="gpa" name="gpa" step="0.1" required min="0" max="4">
            </div>

            <div class="text-end mt-3">
                <a href="education.php" class="btn btn-secondary me-2">
                    <i class="fas fa-times me-1"></i>Hủy
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const startYear = parseInt(document.getElementById('start_year').value);
    const endYear = parseInt(document.getElementById('end_year').value);

    if (startYear > endYear) {
        e.preventDefault();
        alert('Năm bắt đầu không thể lớn hơn năm kết thúc');
    }

    const gpa = parseFloat(document.getElementById('gpa').value);
    if (gpa < 0 || gpa > 4) {
        e.preventDefault();
        alert('GPA phải nằm trong khoảng 0-4');
    }
});
</script>