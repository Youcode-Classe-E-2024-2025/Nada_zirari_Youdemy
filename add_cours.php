<?php
session_start();
require_once '../config.php';
require_once './classes/Course.php';
require_once 'classes/Auth.php';

// Vérification de rôle
Auth::checkRole('teacher');

// Ajouter un cours
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = new Course();
    $course->addCourse(
        $_SESSION['user_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['content'],
        $_POST['category']
    );
    header('Location: teacher_dashboard.php?success=true');
    exit();
}
?>
