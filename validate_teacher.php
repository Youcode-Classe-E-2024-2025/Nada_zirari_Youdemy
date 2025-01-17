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
    $teacherId = intval($_POST['approve'] ?? $_POST['reject']);
    $status = isset($_POST['approve']) ? 'approved' : 'rejected';

    try {
        $stmt = $db->prepare("UPDATE users SET status = :status WHERE id = :id AND role = 'teacher'");
        $stmt->execute([':status' => $status, ':id' => $teacherId]);
        $_SESSION['success'] = "Statut de l'enseignant mis à jour.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
    header("Location: admin_dashboard.php");
    exit;
}
?>
