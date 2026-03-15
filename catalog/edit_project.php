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
    header('Location: project.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

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
    $image = $project['image']; // Giữ ảnh cũ nếu không upload ảnh mới

    // Xử lý upload ảnh nếu có
    if($_FILES['image']['size'] > 0) {
        $target_dir = "uploads/projects/";
        $file = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $image_path = $target_dir . time() . '_' . basename($file);

        // Kiểm tra file ảnh
        if($_FILES['image']['size'] > 5*1024*1024) {
            $err['image'] = "Ảnh không được quá 5MB";
        }
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if(!in_array($ext, $allowed)) {
            $err['image'] = "Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)";
        }

        // Nếu không có lỗi về ảnh
        if(empty($err)) {
            // Xóa ảnh cũ nếu tồn tại
            if ($project['image'] && file_exists($target_dir . $project['image'])) {
                unlink($target_dir . $project['image']);
            }
            
            // Upload ảnh mới
            if(move_uploaded_file($temp_name, $image_path)) {
                $image = time() . '_' . basename($file);
            } else {
                $err['upload'] = "Có lỗi xảy ra khi upload ảnh!";
            }
        }
    }

    // Nếu không có lỗi thì cập nhật database
    if(empty($err)) {
        $sql = "UPDATE projects SET name=?, description=?, technologies=?, start_date=?, 
                end_date=?, status=?, github_link=?, demo_link=?, image=?, role=?, 
                team_size=?, challenges=?, results=? WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssssi", $name, $description, $technologies, $start_date, 
                          $end_date, $status, $github_link, $demo_link, $image, $role, 
                          $team_size, $challenges, $results, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật dự án thành công!'); window.location.href='project.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi cập nhật dự án!');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa dự án
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
                    <input type="text" class="form-control" name="name"
                        value="<?= htmlspecialchars($project['name']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Công nghệ (phân cách bằng dấu phẩy)</label>
                    <input type="text" class="form-control" name="technologies"
                        value="<?= htmlspecialchars($project['technologies']) ?>" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Mô tả dự án</label>
                    <textarea class="form-control" name="description" rows="4"
                        required><?= htmlspecialchars($project['description']) ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="start_date" value="<?= $project['start_date'] ?>"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày kết thúc (nếu có)</label>
                    <input type="date" class="form-control" name="end_date" value="<?= $project['end_date'] ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-control" name="status" required>
                        <option value="planning" <?= $project['status'] == 'planning' ? 'selected' : '' ?>>
                            Lên kế hoạch
                        </option>
                        <option value="in_progress" <?= $project['status'] == 'in_progress' ? 'selected' : '' ?>>
                            Đang thực hiện
                        </option>
                        <option value="completed" <?= $project['status'] == 'completed' ? 'selected' : '' ?>>
                            Hoàn thành
                        </option>
                        <option value="on_hold" <?= $project['status'] == 'on_hold' ? 'selected' : '' ?>>
                            Tạm dừng
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ảnh dự án</label>
                    <?php if ($project['image']): ?>
                    <div class="mb-2">
                        <img src="uploads/projects/<?= htmlspecialchars($project['image']) ?>" id="preview"
                            class="img-thumbnail" style="height: 100px;">
                    </div>
                    <?php else: ?>
                    <img id="preview" class="mt-2" style="max-width: 200px; display: none;">
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image" accept="image/*"
                        onchange="previewImage(event)">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link Github</label>
                    <input type="url" class="form-control" name="github_link"
                        value="<?= htmlspecialchars($project['github_link']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link Demo</label>
                    <input type="url" class="form-control" name="demo_link"
                        value="<?= htmlspecialchars($project['demo_link']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Vai trò của bạn</label>
                    <input type="text" class="form-control" name="role"
                        value="<?= htmlspecialchars($project['role']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số lượng thành viên</label>
                    <input type="number" class="form-control" name="team_size" min="1"
                        value="<?= $project['team_size'] ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Thách thức gặp phải</label>
                    <textarea class="form-control" name="challenges"
                        rows="3"><?= htmlspecialchars($project['challenges']) ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kết quả đạt được</label>
                    <textarea class="form-control" name="results"
                        rows="3"><?= htmlspecialchars($project['results']) ?></textarea>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="project.php" class="btn btn-secondary">Hủy</a>
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
            preview.style.height = '100px';
        }

        reader.readAsDataURL(file);
    }
}
</script>