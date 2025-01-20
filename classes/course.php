<?php
class Course {
    private $db;

    public function __construct() {
        // Obtenez la connexion de la classe Database
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCoursesByTeacher($teacherId) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCourse($teacherId, $title, $description, $content, $category) {
        try {
            // Préparer la requête d'insertion
            $stmt = $this->db->prepare("INSERT INTO courses (title, description, content, category, teacher_id) 
                                        VALUES (:title, :description, :content, :category, :teacher_id)");

            // Lier les paramètres
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':teacher_id', $teacherId);

            // Exécuter la requête
            return $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
?>
