<?php
require_once 'config.php'; // Inclure la configuration

// Données de l'administrateur
$name = 'Admin';
$email = 'admin@gmail.com';
$password = '123456'; // Mot de passe en clair

try {
    // Obtenir la connexion à la base de données
    $db = Database::getInstance();
    $conn = $db->getConnection();

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Définir le rôle avant de lier les paramètres
    $role = 'admin';

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Administrateur ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'administrateur.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
