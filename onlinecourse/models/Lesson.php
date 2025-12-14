<?php

require_once 'config/Database.php';

class Lesson
{
    /** @var PDO $conn */
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    //lay toan bo bai hoc theo khoa hoc
    public function getAllLessonsByCourseId(int $courseId): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT * FROM Lessons WHERE course_id = :course_id ORDER BY order_lesson ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        return $stmt->fetchAll();
    }

    // them bai hoc
    public function addLesson(int $courseId, string $title, string $content, string $videoUrl, string $orderLesson, string $createdAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'INSERT INTO Lessons (course_id, title, content, video_url, order_lesson, created_at)
                VALUES (:course_id, :title, :content, :video_url, :order_lesson, :created_at)';

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':course_id'    => $courseId,
            ':title'        => $title,
            ':content'      => $content,
            ':video_url'    => $videoUrl,
            ':order_lesson' => $orderLesson,
            ':created_at'   => $createdAt,
        ]);
    }

    // xoa bai hoc
    public function deleteLesson(int $lessonId): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql  = 'DELETE FROM Lessons WHERE id = :lesson_id';
        $stmt = $this->conn->prepare($sql);
        $deletedLesson = $stmt->execute([':lesson_id' => $lessonId]);


        $sql = 'DELETE FROM Materials WHERE lesson_id = :lesson_id';
        $stmt = $this->conn->prepare($sql);
        $deletedMaterials = $stmt->execute([':lesson_id' => $lessonId]);

        return $deletedLesson && $deletedMaterials;
    }

    // lay bai hoc theo id
    public function getLessonById(int $lessonId)
    {
        if ($this->conn === null) {
            return null;
        }

        $sql  = 'SELECT * FROM Lessons WHERE id = :lesson_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':lesson_id' => $lessonId]);
        return $stmt->fetch();
    }

    // cap nhat bai hoc
    public function updateLesson(int $lessonId, string $title, string $content, string $videoUrl, string $orderLesson, string $createdAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql  = 'UPDATE Lessons SET title = :title, content = :content, video_url = :video_url, order_lesson = :order_lesson, created_at = :created_at WHERE id = :lesson_id';
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title'        => $title,
            ':content'      => $content,
            ':video_url'    => $videoUrl,
            ':order_lesson' => $orderLesson,
            ':created_at'   => $createdAt,
            ':lesson_id'    => $lessonId,
        ]);
    }

}
