<?php
// Connexion à la base de données
require_once '../config/db.php';

if (isset($_POST['user_id'])) {
    // Récupérer l'ID de l'utilisateur à supprimer
    $user_id = $_POST['user_id'];

    // Commencer la transaction
    $pdo->beginTransaction();

    try {
        // Supprimer l'utilisateur dans la table des inscriptions
        $stmt = $pdo->prepare("DELETE FROM inscription WHERE id_user = ?");
        $stmt->execute([$user_id]);

        // Supprimer tous les cours associés à l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM cours WHERE id_user = ?");
        $stmt->execute([$user_id]);

        // Supprimer tous les tags associés aux cours de cet utilisateur
        $stmt = $pdo->prepare("DELETE FROM cours_tags WHERE id_cours IN (SELECT id_cours FROM cours WHERE id_user = ?)");
        $stmt->execute([$user_id]);

        // Supprimer l'utilisateur de la table des utilisateurs
        $stmt = $pdo->prepare("DELETE FROM user WHERE id_user = ?");
        $stmt->execute([$user_id]);

        // Valider la transaction
        $pdo->commit();

        // Rediriger l'utilisateur vers la liste des utilisateurs ou afficher un message de succès
        header('Location: ../view/AdminDashboard.php');
        exit();

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $conn->rollBack();

        // Afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Si l'ID de l'utilisateur n'est pas passé, rediriger ou afficher un message d'erreur
    echo "Aucun utilisateur spécifié pour la suppression.";
}
?>

