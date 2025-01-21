<?php
// model/Tag.php

class Tag {
    private $id;
    private $name;
    private $pdo; // Instance PDO pour gérer la base de données

    // Constructeur pour initialiser un Tag avec son nom et son ID (optionnel)
    public function __construct($pdo, $name, $id = null) {
        $this->pdo = $pdo;
        $this->setName($name);
        if ($id !== null) {
            $this->setId($id);
        }
    }

    // Getter pour l'ID
    public function getId() {
        return $this->id;
    }

    // Setter pour l'ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter pour le nom
    public function getName() {
        return $this->name;
    }

    // Setter pour le nom
    public function setName($name) {
        $this->name = $name;
    }

    // Méthode pour vérifier si le tag est valide
    public function isValid() {
        return !empty($this->name);
    }

    // Méthode pour insérer ou mettre à jour le tag dans la base de données
    public function save() {
        if (!$this->isValid()) {
            throw new Exception("Le nom du tag est invalide.");
        }

        if ($this->id === null) {
            // Si l'ID est null, c'est une nouvelle insertion
            $stmt = $this->pdo->prepare("INSERT INTO tags (name_tags) VALUES (:name_tags) ON DUPLICATE KEY UPDATE name_tags = :name_tags");
            $stmt->execute([':name_tags' => $this->name]);
            $this->id = $this->pdo->lastInsertId();
        } else {
            // Si l'ID existe déjà, on met à jour le tag
            $stmt = $this->pdo->prepare("UPDATE tags SET name = :name WHERE id_tags = :id");
            $stmt->execute([':name_tags' => $this->name, ':id_tags' => $this->id]);
        }
    }

    // Méthode pour supprimer un tag de la base de données
    public function delete() {
        if ($this->id === null) {
            throw new Exception("Impossible de supprimer un tag sans ID.");
        }

        $stmt = $this->pdo->prepare("DELETE FROM tags WHERE id_tags = :id_tags");
        $stmt->execute([':id_tags' => $this->id]);
    }

    // Méthode pour récupérer tous les tags
    public static function getAll($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM tags");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un tag par son ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM tags WHERE id_tags = :id_tags");
        $stmt->execute([':id_tags' => $id]);
        $tagData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tagData) {
            return new Tag($pdo, $tagData['name_tags'], $tagData['id_tags']);
        }

        return null; // Si le tag n'existe pas
    }

    // Méthode pour récupérer un tag par son nom
    public static function getByName($pdo, $name) {
        $stmt = $pdo->prepare("SELECT * FROM tags WHERE name_tags = :name_tags");
        $stmt->execute([':name_tags' => $name]);
        $tagData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tagData) {
            return new Tag($pdo, $tagData['name_tags'], $tagData['id_tags']);
        }

        return null; // Si le tag n'existe pas
    }
}
?>
