<?php
class Course {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCoursesByTeacher($teacherId) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCourse($teacherId, $title, $description, $content, $category) {
        $stmt = $this->db->prepare("INSERT INTO courses (teacher_id, title, description, content, category) 
                                    VALUES (:teacher_id, :title, :description, :content, :category)");
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category', $category);
        return $stmt->execute();
    }
}
?>
