<?php
session_start();
ob_start();
include '../config.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Lấy thông tin cá nhân
$sql = "SELECT * FROM personal_info WHERE id = 1";
$result = $conn->query($sql);
$info = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NVNH - <?php echo isset($title) ? $title : "Quản lý thông tin"; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .profile-header {
        background-color: #fff;
        padding: 2rem;
        margin-bottom: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .info-section {
        color: #666;
    }

    .info-section i {
        width: 20px;
        text-align: center;
        margin-right: 8px;
    }

    .management-section {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    /* Cập nhật style cho tất cả các nút */
    .btn-custom {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    /* Style mặc định cho các nút */
    .btn-info-personal {
        background-color: #0d6efd;
        color: white;
    }

    .btn-education {
        background-color: #00b8d4;
        color: white;
    }

    .btn-experience {
        background-color: #198754;
        color: white;
    }

    .btn-achievement {
        background-color: #ffc107;
        color: white;
    }

    .btn-skill {
        background-color: #dc3545;
        color: white;
    }

    /* Hiệu ứng hover chung cho tất cả các nút */
    .btn-custom:hover {
        opacity: 0.8;
        color: black;
    }

    /* Style cho avatar */
    .avatar-wrapper {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        position: relative;
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }

    .upload-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .upload-btn:hover {
        background: #fff;
    }

    @media (max-width: 768px) {
        .avatar-wrapper {
            width: 120px;
            height: 120px;
        }
    }

    /* Style cho các nút còn lại */
    .btn-project {
        background-color: #6f42c1;
        /* Màu tím cho Project */
        color: white;
    }

    .btn-document {
        background-color: #fd7e14;
        /* Màu cam cho Document */
        color: white;
    }

    .btn-cv {
        background-color: #20c997;
        /* Màu ngọc cho CV */
        color: white;
    }

    /* Custom icons cho các nút */
    .btn-project i.fas:before {
        content: "\f0b1";
        /* Icon briefcase cho Project */
    }

    .btn-document i.fas:before {
        content: "\f15b";
        /* Icon file cho Document */
    }

    .btn-cv i.fas:before {
        content: "\f2bb";
        /* Icon id-card cho CV */
    }

    .auth-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .auth-button .btn {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .btn-certificate {
        background-color: #9c27b0;
        /* Purple color for certificates */
        color: white;
    }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Profile Header with Management Section -->
        <div class="profile-header">
            <!-- Thông tin cá nhân -->
            <div class="row align-items-center position-relative">
                <!-- Avatar column -->
                <div class="col-md-2 text-center">
                    <div class="avatar-wrapper mb-3 mb-md-0 position-relative">
                        <img src="<?= $info['avatar'] ? '../uploads/avatar/'.$info['avatar'] : '../uploads/avatar/C1220012_NguyenVanNgocHai.jpg' ?>"
                            alt="<?= htmlspecialchars($info['name']) ?>" class="rounded-circle avatar-image">

                        <?php if ($canEdit): ?>
                        <div class="avatar-upload">
                            <label for="avatar-input" class="btn btn-sm btn-light rounded-circle upload-btn">
                                <i class="fas fa-camera"></i>
                            </label>
                            <form id="avatar-form" method="POST" action="upload_avatar.php"
                                enctype="multipart/form-data">
                                <input type="file" id="avatar-input" name="avatar" class="d-none" accept="image/*">
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Name and title column -->
                <div class="col-md-4">
                    <h1 class="mb-1" style="font-size: 2.4rem; !important"><?= htmlspecialchars($info['name']) ?></h1>
                    <p class="text-muted"><?= htmlspecialchars($info['title']) ?></p>
                </div>

                <!-- Contact info column -->
                <div class="col-md-6 text-md-end info-section">
                    <div class="d-flex justify-content-end align-items-start">
                        <div class="me-3">
                            <p><i class="fas fa-envelope"></i><?= htmlspecialchars($info['email']) ?></p>
                            <p><i class="fas fa-phone"></i><?= htmlspecialchars($info['phone']) ?></p>
                            <p class="mb-0"><i
                                    class="fas fa-map-marker-alt"></i><?= htmlspecialchars($info['location']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần quản lý -->
            <div class="management-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Quản lý thông tin</h4>

                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="index.php" class="btn btn-custom btn-info-personal">
                        <i class="fas fa-user me-2"></i>Thông tin cá nhân
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="education.php" class="btn btn-custom btn-education">
                        <i class="fas fa-graduation-cap me-2"></i>Học vấn
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="experience.php" class="btn btn-custom btn-experience">
                        <i class="fas fa-briefcase me-2"></i>Kinh nghiệm
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="achievement.php" class="btn btn-custom btn-achievement">
                        <i class="fas fa-trophy me-2"></i>Thành tựu
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="certificate.php" class="btn btn-custom btn-certificate">
                        <i class="fas fa-certificate me-2"></i>Chứng chỉ
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="skill.php" class="btn btn-custom btn-skill">
                        <i class="fas fa-code me-2"></i>Kỹ năng
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="project.php" class="btn btn-custom btn-project">
                        <i class="fas fa-project-diagram me-2"></i>Dự án
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="document.php" class="btn btn-custom btn-document">
                        <i class="fas fa-file-alt me-2"></i>Tài liệu
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                    <a href="cv.php" class="btn btn-custom btn-cv">
                        <i class="fas fa-id-card me-2"></i>CV
                        <?php if ($canEdit): ?>
                        <i class="fas fa-edit ms-2"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- Auth Button -->
        <div class="auth-button">
            <?php if ($canEdit): ?>
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
            </a>
            <?php else: ?>
            <a href="login.php" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
            </a>
            <?php endif; ?>
        </div>




        <script>
        document.getElementById('avatar-input').onchange = function() {
            // Tự động submit form khi chọn file
            var formData = new FormData(document.getElementById('avatar-form'));

            fetch('upload_avatar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        // Reload ảnh
                        const avatar = document.querySelector('.avatar-image');
                        const newSrc = 'uploads/avatar/' + this.files[0].name;
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            avatar.src = e.target.result;
                        }

                        reader.readAsDataURL(this.files[0]);
                    } else {
                        alert('Lỗi: ' + result);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi upload ảnh');
                });
        };
        </script>