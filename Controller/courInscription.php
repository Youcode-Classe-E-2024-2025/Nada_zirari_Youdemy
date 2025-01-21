<?php
// Inclure la classe User
require_once '../model/user.php';

// Vérifier si l'utilisateur est connecté
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour vous inscrire à un cours.";
    exit;
}

// Obtenir l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Vérifier si l'ID du cours est passé par POST
if (isset($_POST['id_cours']) && !empty($_POST['id_cours'])) {
    $id_cours = $_POST['id_cours'];

    // Vérifier si l'ID du cours est un entier
    if (is_numeric($id_cours)) {
        // Récupérer l'utilisateur à partir de la base de données
        $user = User::getUserById($pdo, $userId);

        // Vérifier si l'utilisateur est bien un objet
        if ($user && $user instanceof User) {
            // Vérifier si l'utilisateur est bien un étudiant
            if ($user->getRoleUser() === 'Etudiant') {
                // Inscrire l'étudiant au cours
                $user->inscrireAuCours($pdo, $id_cours);
            } else {
                echo "Vous devez être un étudiant pour vous inscrire à un cours.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }
    } else {
        echo "L'ID du cours est invalide.";
    }
} else {
    echo "Veuillez sélectionner un cours à rejoindre.";
}
?>
