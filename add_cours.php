<?php
session_start();
require_once 'config.php';
require_once 'classes/Course.php';
require_once 'classes/Auth.php';

Auth::checkRole('teacher');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $content = htmlspecialchars($_POST['content']);
    $category = htmlspecialchars($_POST['category']);
    $teacherId = $_SESSION['user_id'];

    $course = new Course();
    $success = $course->addCourse($teacherId, $title, $description, $content, $category);

    if ($success) {
        header('Location: teacher_dashboard.php?success=1');
    } else {
        header('Location: teacher_dashboard.php?error=1');
    }
    exit();
}
?>
