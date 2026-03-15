<?php
include 'header.php';

$id = $_GET['id'];
$sql = "SELECT * FROM achievements WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$achievement = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $year = $_POST['year'];
    $article_link = $_POST['article_link'];

    $sql = "UPDATE achievements SET title=?, organization=?, year=?, article_link=? WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $title, $organization, $year, $article_link, $id);
    
    if ($stmt->execute()) {
        header("Location: achievement.php");
        exit();
    }
}
?>

<div class="card">
    <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa thành tích
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Tiêu đề thành tích</label>
                <input type="text" class="form-control" name="title"
                    value="<?= htmlspecialchars($achievement['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tổ chức</label>
                <input type="text" class="form-control" name="organization"
                    value="<?= htmlspecialchars($achievement['organization']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Năm đạt được</label>
                <input type="number" class="form-control" name="year" value="<?= $achievement['year'] ?>" min="1900"
                    max="<?= date('Y') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Link bài báo (không bắt buộc)</label>
                <input type="url" class="form-control" name="article_link"
                    value="<?= htmlspecialchars($achievement['article_link']) ?>"
                    placeholder="https://example.com/article">
                <div class="form-text">Nhập link bài báo hoặc bài viết liên quan đến thành tích này</div>
            </div>

            <div class="text-end">
                <a href="achievement.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>