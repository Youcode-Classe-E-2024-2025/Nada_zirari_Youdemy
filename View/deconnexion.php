<?php
session_start();

// Désactiver le cache pour cette page de déconnexion
header("Cache-Control: no-cache, no-store, must-revalidate"); // Pour HTTP/1.1
header("Pragma: no-cache"); // Pour HTTP/1.0
header("Expires: 0"); // Pour HTTP/1.0

// Vérifier si une session est déjà active
if (isset($_SESSION['user_id'])) {
    // Supprimer les cookies de session
    setcookie(session_name(), '', time() - 3600, '/'); // Expirer le cookie de session

    // Détruire toutes les variables de session
    session_unset();
    // Détruire la session
    session_destroy();
}

// Rediriger l'utilisateur vers la page de connexion après la déconnexion
header("Location: login.php");
exit();
?>
