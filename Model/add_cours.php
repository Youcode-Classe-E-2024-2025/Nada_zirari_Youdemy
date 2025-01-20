<?php
session_start();
require_once '../config.php';
require_once '../classes/Course.php';
require_once '../classes/Auth.php';

// Vérification du rôle de l'utilisateur (enseignant)
Auth::checkRole('teacher');

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $content = htmlspecialchars($_POST['content']);
    $category = htmlspecialchars($_POST['category']);
    $teacherId = $_SESSION['user_id'];  // ID de l'enseignant connecté

    // Création de l'objet Course
    $course = new Course();

    // Ajouter le cours dans la base de données
    $success = $course->addCourse($teacherId, $title, $description, $content, $category);

    // Rediriger en fonction du succès ou de l'échec de l'ajout
    if ($success) {
        header('Location: teacher_dashboard.php?success=1');
    } else {
        header('Location: teacher_dashboard.php?error=1');
    }
    exit();
}
?>
