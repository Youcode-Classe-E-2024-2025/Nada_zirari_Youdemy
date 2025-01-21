
<?php
require_once 'config.php';

session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        try {
            $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([':name' => $name]);
            $_SESSION['success'] = "Catégorie ajoutée avec succès.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Le nom de la catégorie est requis.";
    }
    header("Location: model/admin_dashboard.php");
    exit;
}
?>
