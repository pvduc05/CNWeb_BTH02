<?php

require_once 'config/Database.php';

class Material
{
    /** @var PDO $conn */
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAllMaterialsByLessonId(int $lessonId): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql  = 'SELECT * FROM Materials WHERE lesson_id = :lesson_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':lesson_id' => $lessonId]);
        return $stmt->fetchAll();
    }

    public function addMaterial(int $lessonId, string $fileName, string $filePath, string $fileType, string $uploadedAt): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql = 'INSERT INTO Materials (lesson_id, filename, file_path, file_type, uploaded_at)
                VALUES (:lesson_id, :file_name, :file_path, :file_type, :uploaded_at)';

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':lesson_id'   => $lessonId,
            ':file_name'   => $fileName,
            ':file_path'   => $filePath,
            ':file_type'   => $fileType,
            ':uploaded_at' => $uploadedAt,
        ]);
    }
}
