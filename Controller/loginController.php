<?php
 // Démarrer la session pour pouvoir stocker les données

// Inclure la configuration de la base de données et la classe user
require_once '../config/db.php';
require_once '../model/user.php';
session_start();
// Initialiser un tableau d'erreurs pour afficher les messages d'erreur dans la vue
$errors = [];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Récupérer les données du formulaire
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation des données
    if (empty($email)) {
        $errors['email'] = "L'email est requis.";
    }
    if (empty($password)) {
        $errors['password'] = "Le mot de passe est requis.";
    }

    // Si aucune erreur n'est présente, tenter la connexion
    if (empty($errors)) {
        // Appeler la méthode de la classe user pour se connecter
        $user = user::seConnecter($email, $password);
       
        // Si l'utilisateur est trouvé et le mot de passe est correct
        if ($user) {
          
            // Vérifier si l'utilisateur est validé
            if ($user->getIsValid() == 1 && $user->getStatus() == 'activer') {

                if($user->getRoleUser() == 'Enseignant'){
                   // Connexion réussie, rediriger l'utilisateur vers la page d'accueil ou tableau de bord
                $_SESSION['user_id'] = $user->getIdUser();
                $_SESSION['user_name'] = $user->getNomUser();
                $_SESSION['user_role'] = $user->getRoleUser();
                
                header('Location: ../view/teacherInterface.php');
                exit;
                }elseif($user->getRoleUser() == 'Etudiant'){
                // Connexion réussie, rediriger l'utilisateur vers la page d'accueil ou tableau de bord
                $_SESSION['user_id'] = $user->getIdUser();
                $_SESSION['user_name'] = $user->getNomUser();
                $_SESSION['user_role'] = $user->getRoleUser();
                
                header('Location: ../view/studentInterface.php');
                exit;
                }else{
                    $_SESSION['user_id'] = $user->getIdUser();
                    $_SESSION['user_name'] = $user->getNomUser();
                    $_SESSION['user_role'] = $user->getRoleUser();
                    
                    header('Location: ../view/AdminDashboard.php');
                    exit;
                }
                
            } else {
                // L'utilisateur n'est pas validé
                $errors['validation'] = "Votre compte n'est pas encore validé.";
            }
        } else {
            // Informations de connexion invalides
            $errors['credentials'] = "Email ou mot de passe incorrect.";
        }
    }
}

?>
