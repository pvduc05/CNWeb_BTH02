<?php

// Sử dụng __DIR__ để đường dẫn luôn đúng bất kể file được gọi từ đâu
require_once __DIR__ . '/../config/Database.php';

class Course
{
    /** @var PDO $conn */
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // =================================================================
    // PHẦN 1: CÁC HÀM DÀNH CHO GIẢNG VIÊN / QUẢN TRỊ (TỪ FILE 1)
    // =================================================================

    // Lấy toàn bộ khóa học của một giảng viên cụ thể
    public function getAllCourse(int $instructorId): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT * FROM Courses WHERE instructor_id = :instructor_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':instructor_id' => $instructorId,
        ]);
        return $stmt->fetchAll();
    }

    // Thêm khóa học mới
    public function addCourse(string $title, string $description, int $instructorId, int $categoryId, float $price, int $durationWeeks, string $level, string $image, string $createdAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        // Lưu ý: File gốc dùng cột 'level_course'
        $sql = 'INSERT INTO Courses (title, description, instructor_id, category_id, price, duration_weeks, level_course, image, created_at)
                VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, :created_at)';

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title'          => $title,
            ':description'    => $description,
            ':instructor_id'  => $instructorId,
            ':category_id'    => $categoryId,
            ':price'          => $price,
            ':duration_weeks' => $durationWeeks,
            ':level'          => $level,
            ':image'          => $image,
            ':created_at'     => $createdAt,
        ]);
    }

    // Cập nhật khóa học
    public function updateCourse(int $courseId, string $title, string $description, int $instructorId, int $categoryId, float $price, int $durationWeeks, string $level, string $image, string $updatedAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        // Lưu ý: File gốc dùng cột 'level_course'
        $sql = 'UPDATE Courses
                SET title = :title, description = :description, instructor_id = :instructor_id, category_id = :category_id,
                    price = :price, duration_weeks = :duration_weeks, level_course = :level, image = :image , updated_at = :updated_at
                WHERE id = :course_id';

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title'          => $title,
            ':description'    => $description,
            ':instructor_id'  => $instructorId,
            ':category_id'    => $categoryId,
            ':price'          => $price,
            ':duration_weeks' => $durationWeeks,
            ':level'          => $level,
            ':image'          => $image,
            ':course_id'      => $courseId,
            ':updated_at'     => $updatedAt,
        ]);
    }

    // Xóa khóa học (và xóa các bài học liên quan)
    public function deleteCourse(int $courseId): bool
    {
        if ($this->conn === null) {
            return false;
        }

        // Xóa khóa học
        $sql = 'DELETE FROM Courses WHERE id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $deletedCourseSuccess = $stmt->execute([
            ':course_id' => $courseId,
        ]);

        // Xóa bài học thuộc khóa học
        $sql = 'DELETE FROM Lessons WHERE course_id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $deletedLessonsSuccess = $stmt->execute([
            ':course_id' => $courseId,
        ]);

        // Nếu xóa khóa học và bài học thành công thi trả về true
        return $deletedCourseSuccess && $deletedLessonsSuccess;
    }

    // Lấy thông tin cơ bản khóa học theo ID (Dùng cho form Edit của giảng viên)
    public function getCourseById(int $courseId)
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT * FROM Courses WHERE id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
        ]);
        return $stmt->fetch();
    }

    // =================================================================
    // PHẦN 2: CÁC HÀM DÀNH CHO NGƯỜI DÙNG / PUBLIC (TỪ FILE 2)
    // =================================================================

    // Xem danh sách tất cả khóa học (Public)
    public function getAll()
    {
        // Lưu ý: File gốc dùng cột 'level'
        $sql_select = "SELECT id, title, description, price, duration_weeks, level, image FROM courses ORDER BY id ASC";
        $result = $this->conn->query($sql_select);
        return $result->fetchAll();
    }

    /**
     * Lấy 3 khóa học có số lượng đăng ký lớn nhất (Trending)
     */
    public function getThree()
    {
        // Lưu ý: File gốc dùng cột 'level'
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

    // Xem chi tiết khóa học (Bao gồm tên giảng viên và danh mục)
    public function getDetail($courseID)
    {
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
        $stmt->execute(['id' => $courseID]);
        return $stmt->fetch();
    }

    /*
     Tìm kiếm khóa học theo tiêu đề (tương đối)
    */
    public function search($title)
    {
        // Lưu ý: File gốc dùng cột 'level'
        $sql_select = "SELECT id, title, description, price, duration_weeks, level, image FROM courses WHERE title LIKE :title";
        $stmt = $this->conn->prepare($sql_select);
        $stmt->execute(['title' => '%' . $title . '%']);
        return $stmt->fetchAll();
    }
}
