<?php
class Auth {
    public static function checkRole($requiredRole) {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $requiredRole) {
            header('Location: login.php');
            exit();
        }
    }
}