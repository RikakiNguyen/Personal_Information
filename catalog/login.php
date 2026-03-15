<?php
session_start();
ob_start();
include '../config.php';

// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Xử lý đăng nhập
$err = false;
$err_msg = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Debug
    echo "Username: " . $username . "<br>";
    
    if(empty($username) || empty($password)) {
        $err = true;
        $err_msg = 'Vui lòng nhập đầy đủ thông tin!';
    } else {
        // Kiểm tra tài khoản
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Debug
        echo "Số dòng tìm thấy: " . $result->num_rows . "<br>";

        if($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Debug
            echo "Mật khẩu nhập vào: " . $password . "<br>";
            echo "Mật khẩu trong DB: " . $user['password'] . "<br>";
            
            if(password_verify($password, $user['password'])) {
                // Lưu session
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];

                // Debug
                echo "Đăng nhập thành công. Session ID: " . session_id() . "<br>";
                echo "Session data: ";
                print_r($_SESSION);

                // Lưu cookie nếu chọn "Nhớ mật khẩu"
                if($remember) {
                    setcookie('username', $username, time() + (30 * 24 * 60 * 60), '/');
                    setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');
                }

                header("Location: index.php");
                exit();
            } else {
                $err = true;
                $err_msg = 'Mật khẩu không chính xác!';
            }
        } else {
            $err = true;
            $err_msg = 'Tài khoản không tồn tại!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
    </style>
</head>

<body class="bg-light">
    <div class="login-container">
        <!-- Hiển thị thông báo lỗi -->
        <?php if($err): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $err_msg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <h2 class="text-center mb-4">Đăng nhập</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <div class="position-relative">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <i class="far fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Nhớ mật khẩu</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

            <div class="text-center mt-3">
                <a href="forgot-password.php">Quên mật khẩu?</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    </script>
</body>

</html>