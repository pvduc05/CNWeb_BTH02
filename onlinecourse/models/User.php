<?php
include_once 'config/Database.php';
class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $role;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // 1. Chức năng Đăng ký
    public function register()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username=:username, email=:email, password=:password, fullname=:fullname, role=:role, created_at=NOW()";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->role = 0; // Mặc định đăng ký là Học viên (0)

        // Mã hóa mật khẩu
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Gán dữ liệu
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 2. Kiểm tra login (Lấy thông tin user theo username)
    public function loginCheck()
    {
        $query = "SELECT id, username, password, fullname, role FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        return $stmt;
    }

    // 3. Kiểm tra Username hoặc Email đã tồn tại chưa
    public function userExists()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username OR email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) return true;
        return false;
    }
}
