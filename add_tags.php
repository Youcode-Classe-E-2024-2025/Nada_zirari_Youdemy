<?php
require_once '../config.php';

session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tags = trim($_POST['tags']);
    if (!empty($tags)) {
        $tagsArray = array_map('trim', explode(',', $tags));
        try {
            foreach ($tagsArray as $tag) {
                if (!empty($tag)) {
                    $stmt = $db->prepare("INSERT IGNORE INTO tags (name) VALUES (:name)");
                    $stmt->execute([':name' => $tag]);
                }
            }
            $_SESSION['success'] = "Tags ajoutés avec succès.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout des tags : " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Les tags sont requis.";
    }
    header("Location: admin_dashboard.php");
    exit;
}
?>
