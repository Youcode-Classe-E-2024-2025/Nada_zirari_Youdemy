<?php
session_start();
require_once 'config.php';
require_once 'classes/Database.php';

// Vérification si l'utilisateur est un administrateur
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fonction pour ajouter un administrateur
function addAdmin($username, $password) {
    // Connexion à la base de données
    $database = Database::getInstance();
    $conn = $database->getConnection();

    // Hash du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertion de l'administrateur dans la base de données
    $stmt = $conn->prepare("INSERT INTO users (username,email, password, role) VALUES (:username,:email , :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);

    // Définir le rôle de l'utilisateur comme 'admin'
    $role = 'admin';

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Administrateur ajouté avec succès.";
    } else {
        echo "Une erreur est survenue lors de l'ajout de l'administrateur.";
    }
}

// Exemple d'ajout d'un administrateur sans formulaire
$username = "admin";  // Nom d'utilisateur de l'administrateur
$email = "admin@gmail.com";  // Nom d'utilisateur de l'administrateur

$password = "123456";  // Mot de passe de l'administrateur

addAdmin($username,$email, $password);
?>
