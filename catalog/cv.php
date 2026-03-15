<?php 
include 'header.php';
require_once 'auth.php';
$canEdit = isLoggedIn();

// Lấy thông tin cá nhân
$info_sql = "SELECT * FROM personal_info WHERE id = 1";
$info = $conn->query($info_sql)->fetch_assoc();

// Lấy thông tin học vấn - chỉ lấy cao đẳng
$education_sql = "SELECT * FROM education ORDER BY end_year DESC";
$education = $conn->query($education_sql)->fetch_all(MYSQLI_ASSOC);

// Lấy 5 kỹ năng chính
$skills_sql = "SELECT * FROM skills ORDER BY name ASC LIMIT 5";
$skills = $conn->query($skills_sql)->fetch_all(MYSQLI_ASSOC);

// Lấy 2 dự án nổi bật nhất
$projects_sql = "SELECT * FROM projects ORDER BY start_date DESC LIMIT 2";
$projects = $conn->query($projects_sql)->fetch_all(MYSQLI_ASSOC);

// Lấy 2 thành tích quan trọng nhất
$achievements_sql = "SELECT * FROM achievements ORDER BY year DESC LIMIT 2";
$achievements = $conn->query($achievements_sql)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - <?= htmlspecialchars($info['name']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <link rel="stylesheet" href="style_cv.css">
</head>

<body>
    <!-- Control Panel -->
    <?php if ($canEdit): ?>
    <div class="control-panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tùy chỉnh CV</h5>
            <div>
                <button class="btn btn-primary btn-sm me-2" onclick="downloadPDF()">
                    <i class="fas fa-file-pdf me-1"></i>Xuất PDF
                </button>
                <button id="export-pdf">Xuất PDF</button>
                <button class="btn btn-secondary btn-sm" onclick="printCV()">
                    <i class="fas fa-print me-1"></i>In CV
                </button>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="show-contact" checked
                        onchange="toggleSection('contact')">
                    <label class="form-check-label" for="show-contact">Thông tin liên hệ</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="show-education" checked
                        onchange="toggleSection('education')">
                    <label class="form-check-label" for="show-education">Học vấn</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="show-skills" checked
                        onchange="toggleSection('skills')">
                    <label class="form-check-label" for="show-skills">Kỹ năng</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="show-projects" checked
                        onchange="toggleSection('projects')">
                    <label class="form-check-label" for="show-projects">Dự án</label>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="control-panel">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm me-2" onclick="downloadPDF()">
                <i class="fas fa-file-pdf me-1"></i>Xuất PDF
            </button>
            <button id="export-pdf">Xuất PDF</button>
            <button class="btn btn-secondary btn-sm" onclick="printCV()">
                <i class="fas fa-print me-1"></i>In CV
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- CV Container -->
    <div class="cv-container" id="cv-container">
        <div class="cv-content">
            <!-- Profile Section -->
            <section class="cv-section" data-section="profile">
                <div class="profile-header">
                    <div class="profile-img">
                        <img src="../uploads/avatar/<?= $info['avatar'] ?>" alt="Profile">
                    </div>
                    <h1 <?= $canEdit ? 'contenteditable="true"' : '' ?>><?= htmlspecialchars($info['name']) ?></h1>
                    <p <?= $canEdit ? 'contenteditable="true"' : '' ?>><?= htmlspecialchars($info['title']) ?></p>
                </div>
            </section>

            <div class="cv-grid">
                <!-- Left Column -->
                <div class="cv-left">
                    <!-- Contact Section -->
                    <section class="cv-section" data-section="contact">
                        <h2 class="section-title">Liên hệ</h2>
                        <div <?= $canEdit ? 'contenteditable="true"' : '' ?>>
                            <p><i class="fas fa-envelope me-2"></i><?= htmlspecialchars($info['email']) ?></p>
                            <p><i class="fas fa-phone me-2"></i><?= htmlspecialchars($info['phone']) ?></p>
                            <p><i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($info['location']) ?></p>
                        </div>
                    </section>

                    <!-- Skills Section -->
                    <section class="cv-section" data-section="skills">
                        <h2 class="section-title">Kỹ năng chính</h2>
                        <div <?= $canEdit ? 'contenteditable="true"' : '' ?>>
                            <?php foreach ($skills as $skill): ?>
                            <p><i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($skill['name']) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <!-- Right Column -->
                <div class="cv-right">
                    <!-- Education Section -->
                    <section class="cv-section" data-section="education">
                        <h2 class="section-title">Học vấn</h2>
                        <?php foreach ($education as $edu): ?>
                        <div <?= $canEdit ? 'contenteditable="true"' : '' ?> class="education-item">
                            <h3><?= htmlspecialchars($edu['school']) ?></h3>
                            <p><i class="fas fa-graduation-cap me-2"></i><?= htmlspecialchars($edu['degree']) ?></p>
                            <p><i class="fas fa-calendar me-2"></i><?= $edu['start_year'] ?> - <?= $edu['end_year'] ?>
                            </p>
                            <p><i class="fas fa-star me-2"></i>GPA: <?= $edu['gpa'] ?></p>
                        </div>
                        <?php endforeach; ?>
                    </section>

                    <!-- Projects Section -->
                    <section class="cv-section" data-section="projects">
                        <h2 class="section-title">Dự án nổi bật</h2>
                        <?php foreach ($projects as $project): ?>
                        <div <?= $canEdit ? 'contenteditable="true"' : '' ?> class="project-item">
                            <h3><?= htmlspecialchars($project['name']) ?></h3>
                            <p><i class="fas fa-code me-2"></i><?= htmlspecialchars($project['technologies']) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </section>

                    <!-- Achievements Section -->
                    <section class="cv-section" data-section="achievements">
                        <h2 class="section-title">Thành tích</h2>
                        <?php foreach ($achievements as $achievement): ?>
                        <div <?= $canEdit ? 'contenteditable="true"' : '' ?> class="achievement-item">
                            <h3><?= htmlspecialchars($achievement['title']) ?></h3>
                            <p><i class="fas fa-trophy me-2"></i><?= htmlspecialchars($achievement['organization']) ?>
                                - <?= $achievement['year'] ?></p>
                        </div>
                        <?php endforeach; ?>
                    </section>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    document.getElementById("export-pdf").addEventListener("click", function() {
        // Lấy phần tử div bạn muốn xuất
        const element = document.getElementById("cv-content");

        // Tùy chỉnh cấu hình của PDF
        const options = {
            margin: [10, 10, 10, 10], // Lề trên, phải, dưới, trái (đơn vị: mm)
            filename: 'CV_NguyenHai.pdf', // Tên file xuất
            image: {
                type: 'jpeg',
                quality: 0.98
            }, // Chất lượng hình ảnh
            html2canvas: {
                scale: 2
            }, // Độ phân giải của canvas
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            } // Kích thước và khổ giấy
        };

        // Gọi hàm html2pdf để tạo PDF
        html2pdf().set(options).from(element).save();
    });

    // Toggle section visibility
    function toggleSection(sectionName) {
        const checkbox = document.getElementById(`show-${sectionName}`);
        const section = document.querySelector(`[data-section="${sectionName}"]`);

        if (section) {
            if (checkbox.checked) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }
    }

    // Download PDF
    async function downloadPDF() {
        const element = document.getElementById('cv-container');
        const controlPanel = document.querySelector('.control-panel');
        const authButton = document.querySelector('.auth-button');

        // Hide controls temporarily
        if (controlPanel) controlPanel.style.display = 'none';
        if (authButton) authButton.style.display = 'none';

        const opt = {
            margin: [10, 10],
            filename: 'my-cv.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        try {
            await html2pdf().set(opt).from(element).save();
        } catch (err) {
            console.error('Error generating PDF:', err);
            alert('Có lỗi xảy ra khi tạo PDF!');
        } finally {
            // Restore controls
            if (controlPanel) controlPanel.style.display = 'block';
            if (authButton) authButton.style.display = 'block';
        }
    }

    // Print CV
    // Print CV
    function printCV() {
        // Lưu lại vị trí ban đầu của cv-content
        const content = document.querySelector('.cv-content');
        const originalPosition = content.style.position;
        const originalTop = content.style.top;
        const originalLeft = content.style.left;

        // Ẩn các phần khác
        const controlPanel = document.querySelector('.control-panel');
        const authButton = document.querySelector('.auth-button');
        if (controlPanel) controlPanel.style.display = 'none';
        if (authButton) authButton.style.display = 'none';

        // In
        window.print();

        // Khôi phục lại vị trí ban đầu
        content.style.position = originalPosition;
        content.style.top = originalTop;
        content.style.left = originalLeft;

        // Hiện lại các phần đã ẩn
        if (controlPanel) controlPanel.style.display = 'block';
        if (authButton) authButton.style.display = 'block';
    }

    <?php if ($canEdit): ?>
    // Initialize section controls
    document.querySelectorAll('.cv-section').forEach(section => {
        const controls = document.createElement('div');
        controls.className = 'section-controls';
        controls.innerHTML = `
        <button class="btn btn-sm btn-outline-danger" onclick="this.parentElement.parentElement.remove()">
            <i class="fas fa-trash"></i>
        </button>
        <button class="btn btn-sm btn-outline-primary move-up">
            <i class="fas fa-arrow-up"></i>
        </button>
        <button class="btn btn-sm btn-outline-primary move-down">
            <i class="fas fa-arrow-down"></i>
        </button>
    `;
        section.prepend(controls);
    });

    // Move section up/down
    document.querySelectorAll('.move-up').forEach(button => {
        button.addEventListener('click', function() {
            const section = this.closest('.cv-section');
            const prevSection = section.previousElementSibling;
            if (prevSection && prevSection.classList.contains('cv-section')) {
                section.parentNode.insertBefore(section, prevSection);
            }
        });
    });

    document.querySelectorAll('.move-down').forEach(button => {
        button.addEventListener('click', function() {
            const section = this.closest('.cv-section');
            const nextSection = section.nextElementSibling;
            if (nextSection && nextSection.classList.contains('cv-section')) {
                section.parentNode.insertBefore(nextSection, section);
            }
        });
    });

    // Save content after editing
    document.querySelectorAll('[contenteditable="true"]').forEach(element => {
        element.addEventListener('blur', function() {
            // Add AJAX call to save content to database here
            console.log('Content updated:', this.innerHTML);
        });
    });
    <?php endif; ?>
    </script>

</html>