<?php
// Inclusion des fichiers nécessaires
require_once '../config/db.php'; // Connexion à la base de données
require_once '../model/user.php'; // Classe User

// Démarrer la session
session_start();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $nom_user = $_POST['username'];
    $email_user = $_POST['email'];
    $password_user = $_POST['password'];
    $confirm_password_user = $_POST['confirmPassword'];
    $role_user = $_POST['role'];

    // Validation côté serveur

    // Vérifier si tous les champs obligatoires sont remplis
    if (empty($nom_user) || empty($email_user) || empty($password_user) || empty($confirm_password_user) || empty($role_user)) {
        echo "Tous les champs sont requis.";
        exit;
    }

    // Vérification du format de l'email
    if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email est invalide.";
        exit;
    }

    // Vérifier si l'email est déjà utilisé
    $existingUser = User::getUserByEmail($pdo, $email_user);
    if ($existingUser) {
        echo "L'email est déjà utilisé. Veuillez en choisir un autre.";
        exit;
    }

    // Vérification des mots de passe (doivent correspondre)
    if ($password_user !== $confirm_password_user) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Vérification de la longueur du mot de passe (min 6 caractères)
    if (strlen($password_user) < 6) {
        echo "Le mot de passe doit comporter au moins 6 caractères.";
        exit;
    }

    // Créer un objet User avec les données du formulaire
    $user = new User(null, $nom_user, $email_user, $password_user, $role_user);

    // Si l'utilisateur est un enseignant, le compte sera en attente de validation
    if ($role_user == 'Enseignant') {
        $user->setIsValid(0); // L'enseignant est en attente de validation
    } else {
        $user->setIsValid(1); // L'étudiant est validé directement
    }


    // Insérer l'utilisateur dans la base de données
    try {
        // Utilisation de la méthode `registerUser()` pour insérer les données
        $userId = $user->registerUser($pdo);
        
        if ($userId) {
            // Vérification de l'état de l'utilisateur après l'insertion
            $existingUser = User::getUserByEmail($pdo, $email_user);

            // Vérifier si l'utilisateur est désactivé
            if ($existingUser['status'] === 'désactiver') {
                echo "Votre compte est désactivé. Vous ne pouvez pas vous connecter pour le moment.";
                exit;
            }

            // Vérification de la validation de l'utilisateur
            if ($existingUser['is_valid'] == 0) {
                // Si l'utilisateur est enseignant et en attente de validation
                echo "Votre compte est en attente de validation. Veuillez patienter que l'admin le valide.";
                exit;
            }

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $existingUser['id_user'];
            $_SESSION['user_name'] = $existingUser['user_name'];
            $_SESSION['user_email'] = $existingUser['user_email'];
            $_SESSION['user_role'] = $existingUser['user_role'];

            // Si l'utilisateur est valide et activé, procéder à la redirection
            if ($role_user == 'Enseignant') {
                // Rediriger vers la page Enseignant
                header('Location: ../view/teacherInterface.php');
                exit;
            } else {
                // Rediriger vers la page Étudiant
                header('Location: ../view/studentInterface.php');
                exit;
            }
        } else {
            echo "Une erreur est survenue lors de l'inscription.";
        }
    } catch (Exception $e) {
        // Gestion des erreurs
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Veuillez remplir le formulaire d'inscription.";
}
?>
