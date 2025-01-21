<?php
// model/Category.php

class Category {
    private $id;
    private $name;
    private $pdo; // Instance PDO pour gérer la base de données

    // Constructeur pour initialiser une catégorie avec son nom et son ID (optionnel)
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

    // Méthode pour vérifier si la catégorie est valide
    public function isValid() {
        return !empty($this->name);
    }

    // Méthode pour insérer ou mettre à jour la catégorie dans la base de données
    public function save() {
        if (!$this->isValid()) {
            throw new Exception("Le nom de la catégorie est invalide.");
        }

        if ($this->id === null) {
            // Si l'ID est null, c'est une nouvelle insertion
            $stmt = $this->pdo->prepare("INSERT INTO categories (name_categorie) VALUES (:name_categorie) ON DUPLICATE KEY UPDATE name_categorie = :name_categorie");
            $stmt->execute([':name_categorie' => $this->name]);
            $this->id = $this->pdo->lastInsertId();
        } else {
            // Si l'ID existe déjà, on met à jour la catégorie
            $stmt = $this->pdo->prepare("UPDATE categories SET name_categorie = :name_categorie WHERE id_categorie = :id_categorie");
            $stmt->execute([':name_categorie' => $this->name, ':id_category' => $this->id]);
        }
    }

    // Méthode pour supprimer une catégorie de la base de données
    public function delete() {
        if ($this->id === null) {
            throw new Exception("Impossible de supprimer une catégorie sans ID.");
        }

        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id_categorie = :id_categorie");
        $stmt->execute([':id_categorie' => $this->id]);
    }

    // Méthode pour récupérer toutes les catégories
    public static function getAll($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer une catégorie par son ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id_categorie = :id_categorie");
        $stmt->execute([':id_categorie' => $id]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            return new Category($pdo, $categoryData['name_categorie'], $categoryData['id_categorie']);
        }

        return null; // Si la catégorie n'existe pas
    }

    // Méthode pour récupérer une catégorie par son nom
    public static function getByName($pdo, $name) {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE name_categorie = :name_categorie");
        $stmt->execute([':name_categorie' => $name]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            return new Category($pdo, $categoryData['name_categorie'], $categoryData['id_categorie']);
        }

        return null; // Si la catégorie n'existe pas
    }
}
?>
