<?php

require_once 'config/Database.php';

class Lesson {
    /** @var PDO $conn */
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    //lay toan bo bai hoc theo khoa hoc
    public function getAllLessonsByCourseId(int $courseId) : array {
        if ($this->conn === null) {
            return [];
        }

        $sql = 'SELECT * FROM Lessons WHERE course_id = :course_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        return $stmt->fetchAll();
    }

    // them bai hoc
    public function addLesson(int $courseId, string $title, string $content, string $videoUrl, string $createdAt) : bool {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'INSERT INTO Lessons (course_id, title, content, video_url, created_at) 
                VALUES (:course_id, :title, :content, :video_url, :created_at)';

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':course_id' => $courseId,
            ':title' => $title,
            ':content' => $content,
            ':video_url' => $videoUrl,
            ':created_at' => $createdAt
        ]);
    }

    // xoa bai hoc
    public function deleteLesson(int $lessonId) : bool {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'DELETE FROM Lessons WHERE id = :lesson_id';
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':lesson_id' => $lessonId]);
    }


}