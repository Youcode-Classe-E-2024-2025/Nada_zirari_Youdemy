<?php
class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour créer une catégorie
    public function create() {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = trim($_POST['name']);
            if ($this->isValidName($name)) {
                try {
                    $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
                    $stmt->execute([':name' => $name]);
                    header('Location: /admin/categories');
                    exit();
                } catch (PDOException $e) {
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                echo 'Nom de la catégorie invalide.';
            }
        } else {
            echo 'Le nom de la catégorie est requis.';
        }
    }

    // Méthode pour mettre à jour une catégorie
    public function update() {
        if (isset($_POST['id'], $_POST['name']) && !empty($_POST['id']) && !empty($_POST['name'])) {
            $id = (int) $_POST['id'];
            $name = trim($_POST['name']);
            if ($this->isValidName($name)) {
                try {
                    $stmt = $this->pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
                    $stmt->execute([':name' => $name, ':id' => $id]);
                    header('Location: /admin/categories');
                    exit();
                } catch (PDOException $e) {
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                echo 'Nom de la catégorie invalide.';
            }
        } else {
            echo 'ID et nom de la catégorie requis.';
        }
    }

    // Méthode pour supprimer une catégorie
    public function delete() {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = (int) $_POST['id'];
            try {
                $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
                $stmt->execute([':id' => $id]);
                header('Location: /admin/categories');
                exit();
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            echo 'ID de la catégorie requis.';
        }
    }

    // Méthode de validation du nom de la catégorie
    private function isValidName($name) {
        return !empty($name) && strlen($name) <= 255; // Par exemple, vérifier que le nom n'est pas vide et qu'il ne dépasse pas 255 caractères
    }
}
?>
