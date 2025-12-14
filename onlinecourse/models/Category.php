<?php
require_once __DIR__ . '/../config/Database.php';

class Category
{
    private $conn;
    private $table = 'categories';

    // Các thuộc tính tương ứng với cột trong DB
    public $id;
    public $name;
    public $description;
    public $created_at;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // 1. Lấy danh sách tất cả danh mục
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 2. Lấy thông tin 1 danh mục (để sửa)
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        // Gán dữ liệu vào object hiện tại
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->created_at = $row['created_at'];
            return $row;
        }
        return null;
    }

    // 3. Tạo danh mục mới
    public function create()
    {
        // Query chèn dữ liệu (created_at lấy giờ hiện tại)
        $query = "INSERT INTO " . $this->table . " SET name=:name, description=:description, created_at=NOW()";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Gán dữ liệu
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 4. Cập nhật danh mục
    public function update()
    {
        $query = "UPDATE " . $this->table . " SET name=:name, description=:description WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 5. Xóa danh mục
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


}
