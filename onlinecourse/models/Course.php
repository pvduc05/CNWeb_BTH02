<?php

require_once 'config/Database.php';
require_once 'models/Lesson.php';

class Course
{
    /** @var PDO $conn */
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    //lay toan bo khoa hoc
    public function getAllCourse(int $instructorId): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT c.*, cat.name as category_name FROM Courses c 
                 LEFT JOIN Categories cat ON c.category_id = cat.id 
                 WHERE c.instructor_id = :instructor_id 
                 ORDER BY c.created_at DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':instructor_id' => $instructorId,
        ]);
        return $stmt->fetchAll();
    }

    //them khoa hoc moi
    public function addCourse(string $title, string $description, int $instructorId, int $categoryId, float $price, int $durationWeeks, string $level, string $image, string $createdAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'INSERT INTO Courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at)
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

    //cap nhat khoa hoc
    public function updateCourse(int $courseId, string $title, string $description, int $instructorId, int $categoryId, float $price, int $durationWeeks, string $level, string $image, string $updatedAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'UPDATE Courses
                SET title = :title, description = :description, instructor_id = :instructor_id, category_id = :category_id,
                    price = :price, duration_weeks = :duration_weeks, level = :level, image = :image , updated_at = :updated_at
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

    // xoa khoa hoc
    public function deleteCourse(int $courseId): bool
    {
        if ($this->conn === null) {
            return false;
        }

        //xoa tai lieu thuoc bai hoc
        $sql = 'DELETE m
            FROM materials m
            JOIN lessons l ON m.lesson_id = l.id
            WHERE l.course_id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $deletedMaterialsSuccess = $stmt->execute([':course_id' => $courseId]);

        //xoa bai hoc thuoc khoa hoc
        $sql                   = 'DELETE FROM Lessons WHERE course_id = :course_id';
        $stmt                  = $this->conn->prepare($sql);
        $deletedLessonsSuccess = $stmt->execute([
            ':course_id' => $courseId,
        ]);

        // xoa khoa hoc
        $sql                  = 'DELETE FROM Courses WHERE id = :course_id';
        $stmt                 = $this->conn->prepare($sql);
        $deletedCourseSuccess = $stmt->execute([
            ':course_id' => $courseId,
        ]);

        // neu xoa khoa hoc va bai hoc thanh cong thi tra ve true
        return $deletedMaterialsSuccess && $deletedCourseSuccess && $deletedLessonsSuccess;
    }

    //lay khoa hoc theo id
    public function getCourseById(int $courseId)
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT c.*, cat.name as category_name FROM Courses c 
                 LEFT JOIN Categories cat ON c.category_id = cat.id 
                 WHERE c.id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
        ]);
        return $stmt->fetch();
    }
}
