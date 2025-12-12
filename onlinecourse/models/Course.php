<?php
require(__DIR__ . "/../config/Database.php");
class Course {
    private $conn;
    public function __construct() {
        $this->conn = Database::getConnection();
    }
    //Xem danh sách khóa học
    public function getAll (){
    $sql_select = "SELECT id, title, description,price,duration_weeks,level,image FROM courses ORDER BY id ASC";
    $result = $this->conn->query($sql_select);
    return $result->fetchAll();
    }
   /**
 * Lấy 3 khóa học có số lượng đăng ký lớn nhất.
 */
public function getThree() {
    $sql = "
        SELECT
            c.id,
            c.title,
            c.description,
            c.price,
            c.duration_weeks,
            c.level,
            c.image,
            COUNT(e.id) AS enrollment_count  
        FROM
            courses c
        LEFT JOIN
            enrollments e ON c.id = e.course_id
        GROUP BY
            c.id, c.title, c.description, c.price, c.duration_weeks, c.level, c.image
        ORDER BY
            enrollment_count DESC  
        LIMIT 3;  
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(); 
}
    // Xem chi tiết khóa học
    public function getDetail ($courseID){
        $sql_select = "
            SELECT 
                c.*, 
                u.fullname AS instructor_name, 
                cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql_select);
        $stmt->execute(['id'=> $courseID]);
        return $stmt->fetch();
    }
    /*
    Tìm kiếm khóa học theo tiêu đề (nên tìm kiếm tương đối)
    */
    public function search ($title){
        $sql_select = "SELECT id, title, description,price,duration_weeks,level,image  FROM courses WHERE title LIKE :title";
        $stmt = $this->conn->prepare($sql_select);
        $stmt->execute(['title'=>'%'.$title.'%']);
        return $stmt->fetchAll();
    }
    
}


?>