<?php
include_once(__DIR__ . "/../config/Database.php");
class Enrollment {
    private $conn;
    public function __construct() {
        $this->conn = Database::getConnection();
    }
    /*
    Kiểm tra xem học viên đã ghi danh vào khóa học này chưa
    */
    public function isEnrolled($courseId, $studentId)
    {
        $sql = "SELECT * FROM enrollments WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'course_id' => $courseId, 
            'student_id' => $studentId
        ]);
        
        return $stmt->fetch(); // Trả về bản ghi nếu tồn tại
    }
    /*
    Ghi danh học viên vào khóa học
    */
    public function enrollCourse($courseId, $studentId) {
        if ($this->isEnrolled($courseId, $studentId)) {
            return false; 
        }
        $sql = "
            INSERT INTO enrollments (course_id, student_id, enrolled_date, status, progress) 
            VALUES (:course_id, :student_id, NOW(), 'active', 0)
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'course_id' => $courseId,
            'student_id' => $studentId
        ]);
    }
    /*
    Lấy danh sách khóa học mà học viên đã đăng ký
    */
    public function getMyCourses($studentId){
        $sql = "
            SELECT 
                e.progress, 
                e.status, 
                c.title, 
                c.image, 
                c.id AS course_id
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.student_id = :student_id
            ORDER BY e.enrolled_date DESC
        ";  
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll();
    }
    /*Theo dõi khóa học*/
    public function trackProgress($courseId, $studentId, $newProgress)
    {
        // Đảm bảo progress nằm trong khoảng 0-100
        $newProgress = max(0, min(100, $newProgress));  
        $sql = "
            UPDATE enrollments 
            SET progress = :progress, 
                status = CASE WHEN :progress = 100 THEN 'completed' ELSE 'active' END
            WHERE course_id = :course_id AND student_id = :student_id
        ";  
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'progress' => $newProgress,
            'course_id' => $courseId,
            'student_id' => $studentId
        ]);
    }
    public function getCoursesByStudent($studentId)
{
    $sql = "SELECT c.* FROM enrollments e 
            INNER JOIN courses c ON e.course_id = c.id 
            WHERE e.student_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll();
}

}
?>