<?php 
include 'header.php';
require_once 'auth.php';
checkLogin();

// Lấy thông tin hiện tại
$sql = "SELECT * FROM personal_info WHERE id = 1";
$result = $conn->query($sql);
$info = $result->fetch_assoc();

// Xử lý cập nhật khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $dob = $_POST['dob'];

    $sql = "UPDATE personal_info SET 
            name = ?, 
            title = ?,
            email = ?,
            phone = ?,
            location = ?,
            dob = ?
            WHERE id = 1";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $title, $email, $phone, $location, $dob);
    
    if ($stmt->execute()) {
        // Chuyển hướng về trang index sau khi cập nhật thành công
        header("Location: index.php");
        exit();
    } else {
        $error = "Có lỗi xảy ra khi cập nhật thông tin";
    }
}
?>

<div class="card">
    <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin cá nhân
        </h5>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= htmlspecialchars($info['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Chức danh</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= htmlspecialchars($info['title']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= htmlspecialchars($info['email']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            value="<?= htmlspecialchars($info['phone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="location" name="location"
                            value="<?= htmlspecialchars($info['location']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="dob" name="dob"
                            value="<?= htmlspecialchars($info['dob']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="index.php" class="btn btn-secondary me-2">
                    <i class="fas fa-times me-1"></i>Hủy
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Thêm validate form nếu cần
document.querySelector('form').addEventListener('submit', function(e) {
    // Validate phone
    const phone = document.getElementById('phone').value;
    if (!/^\+?[\d\s-]+$/.test(phone)) {
        e.preventDefault();
        alert('Số điện thoại không hợp lệ');
        return;
    }

    // Validate email
    const email = document.getElementById('email').value;
    if (!/\S+@\S+\.\S+/.test(email)) {
        e.preventDefault();
        alert('Email không hợp lệ');
        return;
    }
});
</script>