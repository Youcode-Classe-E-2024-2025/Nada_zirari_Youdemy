<?php
// Connexion à la base de données
require_once '../config/db.php';

if (isset($_POST['supprimer'])) {
    // Récupérer l'ID de l'utilisateur à supprimer
    $id_user = $_POST['user_id'];

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id_user = ?");
    $stmt->execute([$id_user]);
    $professeur = $stmt->fetch();

    if ($professeur) {
        // Démarrer la transaction
        $pdo->beginTransaction();
        
        try {
            // Suppression des inscriptions associées à ce professeur
            $stmt1 = $pdo->prepare("DELETE FROM inscription WHERE id_user = ?");
            $stmt1->execute([$id_user]);

            // Suppression des tags associés aux cours du professeur
            $stmt2 = $pdo->prepare("DELETE FROM cours_tags WHERE id_cours IN (SELECT id_cours FROM cours WHERE id_user = ?)");
            $stmt2->execute([$id_user]);

            // Suppression des cours créés par ce professeur
            $stmt3 = $pdo->prepare("DELETE FROM cours WHERE id_user = ?");
            $stmt3->execute([$id_user]);

            // Suppression de l'utilisateur (professeur)
            $stmt4 = $pdo->prepare("DELETE FROM user WHERE id_user = ?");
            $stmt4->execute([$id_user]);

            // Commit de la transaction si tout est OK
            $pdo->commit();
            
            header('Location: ../view/AdminDashboard.php');
            exit;
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $pdo->rollBack();
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        echo "Professeur introuvable.";
    }
}
?>
