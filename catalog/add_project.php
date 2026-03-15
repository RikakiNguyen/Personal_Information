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
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];
    $start_date = $_POST['start_date'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $status = $_POST['status'];
    $github_link = $_POST['github_link'];
    $demo_link = $_POST['demo_link'];
    $role = $_POST['role'];
    $team_size = $_POST['team_size'];
    $challenges = $_POST['challenges'];
    $results = $_POST['results'];
    
    $err = [];

    // Xử lý upload ảnh
    $target_dir = "../uploads/projects/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if($_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $image_name = time() . '_' . basename($image);
        $image_path = $target_dir . $image_name;

        // Kiểm tra file ảnh
        if($_FILES['image']['size'] > 5*1024*1024) {
            $err['image'] = "Ảnh không được quá 5MB";
        }
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if(!in_array($ext, $allowed)) {
            $err['image'] = "Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)";
        }
    } else {
        $err['image'] = "Vui lòng chọn ảnh cho dự án";
    }

    // Nếu không có lỗi thì thêm vào database
    if(empty($err)) {
        if (move_uploaded_file($temp_name, $image_path)) {
            $sql = "INSERT INTO projects (name, description, technologies, start_date, end_date, 
                                        status, github_link, demo_link, image, role, team_size, 
                                        challenges, results) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssssss", $name, $description, $technologies, $start_date, 
                          $end_date, $status, $github_link, $demo_link, $image_name, $role, 
                          $team_size, $challenges, $results);
            
            if ($stmt->execute()) {
                header("Location: project.php?msg=Thêm dự án thành công");
                exit();
            } else {
                $err['db'] = "Có lỗi xảy ra khi thêm dự án: " . $conn->error;
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        } else {
            $err['upload'] = "Có lỗi khi upload ảnh!";
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm dự án mới
        </h5>
    </div>
    <div class="card-body">
        <?php if(!empty($err)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach($err as $error): ?>
                <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên dự án</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Công nghệ (phân cách bằng dấu phẩy)</label>
                    <input type="text" class="form-control" name="technologies" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Mô tả dự án</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="start_date" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày kết thúc (nếu có)</label>
                    <input type="date" class="form-control" name="end_date">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-control" name="status" required>
                        <option value="planning">Lên kế hoạch</option>
                        <option value="in_progress">Đang thực hiện</option>
                        <option value="completed">Hoàn thành</option>
                        <option value="on_hold">Tạm dừng</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ảnh dự án <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="image" accept="image/*" required
                        onchange="previewImage(event)">
                    <img id="preview" class="mt-2" style="max-width: 200px; display: none;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link Github</label>
                    <input type="url" class="form-control" name="github_link">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link Demo</label>
                    <input type="url" class="form-control" name="demo_link">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Vai trò của bạn</label>
                    <input type="text" class="form-control" name="role" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số lượng thành viên</label>
                    <input type="number" class="form-control" name="team_size" min="1" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Thách thức gặp phải</label>
                    <textarea class="form-control" name="challenges" rows="3"></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kết quả đạt được</label>
                    <textarea class="form-control" name="results" rows="3"></textarea>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="project.php" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    }
}
</script>