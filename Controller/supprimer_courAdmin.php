<?php
require_once '../config/db.php';  // Inclure la connexion à la base de données
require_once '../model/cours.php';  // Inclure la classe Cours (et ses sous-classes)
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cours_id']) && isset($_POST['supprimer'])) {
    $cours_id = $_POST['cours_id'];

    // Vous devez d'abord récupérer l'utilisateur actuel, par exemple depuis la session
    $id_user = $_SESSION['user_id'];  // Assurez-vous que l'utilisateur est connecté

    // Instancier l'objet Cours (ici, en fonction de la manière dont vous gérez les différents types de cours)
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE id_cours = ?');
    $stmt->execute([$cours_id]);
    $course_data = $stmt->fetch();

    if ($course_data) {
        $cours = null;
        // Créer l'objet Cours en fonction du type de contenu
        if ($course_data['content_type'] === 'markdown') {
            $cours = new CoursMarkdown(
                $course_data['titre_cours'],
                $course_data['desc_cours'],
                $course_data['content_type'],
                $course_data['content_cours'],
                $course_data['id_user'],
                $course_data['id_categorie'],
                $course_data['image_cours'],
                $course_data['id_cours']
            );
        } elseif ($course_data['content_type'] === 'video') {
            $cours = new CoursVideo(
                $course_data['titre_cours'],
                $course_data['desc_cours'],
                $course_data['content_type'],
                $course_data['content_cours'],
                $course_data['id_user'],
                $course_data['id_categorie'],
                $course_data['image_cours'],
                $course_data['id_cours']
            );
        }

        // Appeler la méthode de suppression
        if ($cours) {
            $cours->supprimerCours($pdo);
        }
    }
}

// Rediriger l'utilisateur après la suppression
header('Location: ../view/AdminDashboard.php');
exit();
?>
