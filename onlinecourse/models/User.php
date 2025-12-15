<?php

require_once 'config/Database.php';

class User {

    /** @var PDO $conn */
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAllStudentsByInstructorId(int $instructorId) : array {
        $sql = 'SELECT 
                u.id        AS student_id,
                u.fullname  AS student_name,
                u.email,
                c.title     AS course_title
                FROM enrollments e
                JOIN users u   ON e.student_id = u.id
                JOIN courses c ON e.course_id = c.id
                WHERE c.instructor_id = :instructor_id
                ORDER BY u.fullname, c.title';

        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['instructor_id' => $instructorId]);

        return $stmt->fetchAll();
    }
}