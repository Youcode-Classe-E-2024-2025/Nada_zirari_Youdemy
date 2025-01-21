<?php

// Inclure la classe User et la connexion à la base de données
require_once '../model/user.php'; // Inclure la classe user
require_once '../config/db.php';   // Inclure le fichier de connexion PDO

// Vérifier si un formulaire a été soumis avec l'ID utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    class UserController {

        // Méthode pour activer ou désactiver un utilisateur
        public function toggleUserActivation($userId) {
            global $pdo;  // Utiliser la connexion PDO depuis le fichier db.php
            $user = new user($userId, '', '', '', '',''); // Créez un objet utilisateur avec l'ID

            // Appel de la méthode pour activer/désactiver l'utilisateur
            $user->toggleUserActivation($pdo);

            // Rediriger vers une page de confirmation après l'activation/désactivation
            header("Location: ../view/AdminDashboard.php"); // Rediriger après l'activation/désactivation
            exit();  // Toujours appeler exit après une redirection
        }
    }

    // Créer une instance du contrôleur et appeler la méthode toggleUserActivation avec l'ID utilisateur
    $controller = new UserController();
    $controller->toggleUserActivation($user_id); // Passer l'ID utilisateur à la méthode toggleUserActivation
}

?>
