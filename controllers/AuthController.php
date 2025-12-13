<?php
// Sử dụng __DIR__ để đường dẫn luôn đúng
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        } else {
            // Sửa đường dẫn view
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
        } else {
            // Sửa đường dẫn view
            include __DIR__ . '/../views/auth/register.php';
        }
    }

    // Xử lý logic đăng nhập
    private function processLogin()
    {
        // Lưu ý: Đảm bảo form HTML name="username" hoặc đổi thành "email" tùy DB của bạn
        $this->user->username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $this->user->loginCheck();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra mật khẩu hash
            if (password_verify($password, $row['password'])) {

                // Đăng nhập thành công -> Lưu Session
                $_SESSION['user'] = [
                    'id'       => $row['id'],
                    'username' => $row['username'],
                    'fullname' => $row['fullname'],
                    'role'     => $row['role'],
                    'avatar'   => $row['avatar'] ?? 'default.png' // Thêm avatar nếu có
                ];

                // Phân quyền điều hướng
                $this->redirectBasedOnRole($row['role']);
            } else {
                $error = "Sai mật khẩu!";
                include __DIR__ . '/../views/auth/login.php';
            }
        } else {
            $error = "Tài khoản không tồn tại!";
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    // Xử lý logic đăng ký
    private function processRegister()
    {
        $this->user->username = $_POST['username'];
        $this->user->email    = $_POST['email'];
        $this->user->fullname = $_POST['fullname'];
        $this->user->password = $_POST['password']; // Model nên tự hash password này

        if ($this->user->userExists()) {
            $error = "Username hoặc Email đã tồn tại!";
            include __DIR__ . '/../views/auth/register.php';
        } else {
            if ($this->user->register()) {
                // Đăng ký thành công -> chuyển sang login
                header("Location: index.php?controller=auth&action=login&msg=registered");
                exit();
            } else {
                $error = "Đăng ký thất bại. Vui lòng thử lại.";
                include __DIR__ . '/../views/auth/register.php';
            }
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=home");
        exit();
    }

    // ==========================================================
    // HÀM ĐIỀU HƯỚNG QUAN TRỌNG
    // ==========================================================
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 2: // Admin
                // Chuyển về index.php?controller=admin
                header("Location: index.php?controller=admin");
                break;

            case 1: // Instructor (Giảng viên)
                // Chuyển về index.php?controller=instructor
                header("Location: index.php?controller=instructor");
                break;

            case 0: // Student (Học viên)
                // Chuyển về index.php?controller=student
                // Index.php sẽ tự include views/student/dashboard.php
                header("Location: index.php?controller=student");
                break;

            default:
                // Mặc định về trang chủ
                header("Location: index.php");
                break;
        }
        exit(); // Luôn exit sau khi header location
    }
}
