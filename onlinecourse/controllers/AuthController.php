<?php
include_once 'config/Database.php';
include_once 'models/User.php';

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
            include 'views/auth/login.php';
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
        } else {
            include 'views/auth/register.php';
        }
    }

    // Xử lý logic đăng nhập
    private function processLogin()
    {
        $this->user->username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $this->user->loginCheck();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Kiểm tra mật khẩu hash
            if (password_verify($password, $row['password'])) {
                // Đăng nhập thành công -> Lưu Session
                $_SESSION['user'] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'fullname' => $row['fullname'],
                    'role' => $row['role']
                ];

                // Phân quyền điều hướng
                $this->redirectBasedOnRole($row['role']);
            } else {
                $error = "Sai mật khẩu!";
                include 'views/auth/login.php';
            }
        } else {
            $error = "Tài khoản không tồn tại!";
            include 'views/auth/login.php';
        }
    }

    // Xử lý logic đăng ký
    private function processRegister()
    {
        $this->user->username = $_POST['username'];
        $this->user->email = $_POST['email'];
        $this->user->fullname = $_POST['fullname'];
        $this->user->password = $_POST['password'];

        if ($this->user->userExists()) {
            $error = "Username hoặc Email đã tồn tại!";
            include 'views/auth/register.php';
        } else {
            if ($this->user->register()) {
                header("Location: index.php?controller=auth&action=login&msg=registered");
            } else {
                $error = "Đăng ký thất bại. Vui lòng thử lại.";
                include 'views/auth/register.php';
            }
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header("Location: index.php");
    }

    // Hàm phụ: Điều hướng theo Role
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 2: // Admin
                header("Location: index.php?controller=admin&action=dashboard");
                break;
            case 1: // Instructor
                header("Location: index.php?controller=instructor&action=dashboard");
                break;
            case 0: // Student (Default)
            default:
                header("Location: index.php?controller=student&action=dashboard");
                break;
        }
    }
}
