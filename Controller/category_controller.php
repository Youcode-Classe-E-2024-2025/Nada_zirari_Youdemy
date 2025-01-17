<?php
class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create() {
        $name = $_POST['name'];
        $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        header('Location: /admin/categories');
    }

    public function update() {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stmt = $this->pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->execute([':name' => $name, ':id' => $id]);
        header('Location: /admin/categories');
    }

    public function delete() {
        $id = $_POST['id'];
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header('Location: /admin/categories');
    }
}
