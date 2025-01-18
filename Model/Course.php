<?php

class CourseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer les cours avec pagination
    public function getCourses($limit, $offset) {
        $query = "SELECT * FROM courses ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter tous les cours
    public function countAllCourses() {
        $query = "SELECT COUNT(*) AS total FROM courses";
        $stmt = $this->pdo->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Rechercher des cours par mots-clés
    public function searchCourses($keyword, $limit, $offset) {
        $query = "SELECT * FROM courses WHERE MATCH(title, description) AGAINST(:keyword IN NATURAL LANGUAGE MODE) LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter les résultats de recherche
    public function countSearchResults($keyword) {
        $query = "SELECT COUNT(*) AS total FROM courses WHERE MATCH(title, description) AGAINST(:keyword IN NATURAL LANGUAGE MODE)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
