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
    // 4. Lấy danh sách tất cả người dùng (Cho trang quản lý của Admin)
    public function getAllUsers()
    {
        // Lấy thêm created_at để admin biết ngày tạo
        $query = "SELECT id, username, email, fullname, role, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 5. Lấy thông tin chi tiết 1 user theo ID (Để hiển thị vào form Sửa)
    public function getUserById($id)
    {
        $query = "SELECT id, username, email, fullname, role, created_at FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Gán giá trị vào thuộc tính của object nếu tìm thấy
        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->fullname = $row['fullname'];
            $this->role = $row['role'];
        }
        return $row;
    }

    // 6. Cập nhật thông tin User (Admin dùng để sửa Tên, Email, Quyền hạn)
    public function update($id, $fullname, $email, $role)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET fullname = :fullname, email = :email, role = :role 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $fullname = htmlspecialchars(strip_tags($fullname));
        $email = htmlspecialchars(strip_tags($email));
        $role = htmlspecialchars(strip_tags($role));
        $id = htmlspecialchars(strip_tags($id));

        // Bind tham số
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 7. Xóa User
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
