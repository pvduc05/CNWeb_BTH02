<?php
include_once(__DIR__ . "/../config/Database.php");
class Category {
    
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
    public function getAll() {
        $sql_select = "SELECT id, title, description,price,duration_weeks,level,image,created_at,update_at  FROM courses ORDER BY id ASC";
        try {
            $stmt = $this->conn->prepare($sql_select);
            $stmt->execute();
            return $stmt->fetchAll();       
        } catch (PDOException $e) {
            error_log("Database error in Category::getAll: " . $e->getMessage());
            return [];
        }
    }
    public function getById($id) {
        $sql_select = "SELECT id, name, description FROM categories WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql_select);
        $stmt->execute(['id' => $id]);
        
        // Chỉ cần fetch một bản ghi
        return $stmt->fetch();
    }
}
?>