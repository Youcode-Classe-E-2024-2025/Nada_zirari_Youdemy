<?php
require_once '../config/db.php';

class user{
     
    //  propriétes de la classe user
     private $id_user;
     private $nom_user;
     private $email_user;
     private $passWord_user;
     private $role_user;
     private $is_valid;
     private $status;

     // constructeur de la classe user
     public function __construct($id_user, $nom_user, $email_user, $passWord_user, $role_user){
        $this->id_user = $id_user;
        $this->nom_user = $nom_user;
        $this->email_user = $email_user;
        $this->passWord_user = $passWord_user;
        $this->role_user = $role_user;
     }
    
    //  getters pour la classe user
    public function getIdUser(){ return $this->id_user ;}

    public function getNomUser(){return $this->nom_user ;}

    public function getEmailUser(){return $this->email_user ;}

    public function getRoleUser(){return $this->role_user ;}

    public function getIsValid() { return $this->is_valid; }

    public function getStatus() { return $this->status; }



   //  setters pour la classe user
   public function setNomUser($nom_user){$this->nom_user = $nom_user;}

   public function setEmailUser($email_user){$this->email_user = $email_user;}

   public function setPasswordUser($passWord_user){$this->passWord_user = $passWord_user ;}

   public function setRoleUser($role_user){$this->role_user = $role_user;}

   public function setIsValid($is_valid) { $this->is_valid = $is_valid; }

   public function setStatus($status) { $this->status = $status; }



public function registerUser($db) {
    // Hash du mot de passe

    // Si l'utilisateur est un enseignant, on laisse is_valid = 0 (en attente de validation)
    if ($this->role_user == 'enseignant') {
        $this->is_valid = 0; // L'utilisateur enseignant est en attente de validation
    } else {
        // Si c'est un étudiant, le compte est directement validé
        $this->is_valid = 1; // L'utilisateur étudiant est validé automatiquement
    }

    // Si la propriété status n'est pas définie, on lui attribue la valeur par défaut 'désactiver'
    if (empty($this->status)) {
        $this->status = 'activer'; // Valeur par défaut pour la colonne status
    }

    // Requête d'insertion de l'utilisateur
    $query = "INSERT INTO user (user_name, user_email, user_password, user_role, is_valid, status) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->nom_user, $this->email_user, password_hash($this->passWord_user, PASSWORD_DEFAULT), $this->role_user, $this->is_valid, $this->status]);

    // Retourner l'ID de l'utilisateur
    return $db->lastInsertId();
}
public static function seConnecter($email_user, $mot_de_passe) {
    global $pdo;

    // Préparation de la requête pour récupérer l'utilisateur
    $query = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email_user]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'existe pas, on renvoie null
    if (!$utilisateur) {
        echo "Utilisateur non trouvé.";
        return null;
    }

    // Vérification du mot de passe
    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['user_password'])) {
        // Crée l'objet utilisateur avec toutes les propriétés, y compris is_valid
        $user = new user(
            $utilisateur['id_user'],
            $utilisateur['user_name'],
            $utilisateur['user_email'],
            $utilisateur['user_password'],
            $utilisateur['user_role']
        );

        // Définir les propriétés is_valid et status
        $user->setIsValid($utilisateur['is_valid']);
        $user->setStatus($utilisateur['status']);

        return $user;
    }

    // Si le mot de passe est incorrect
    echo "Mot de passe incorrect.";
    return null;
}






 // Méthode pour valider un utilisateur (par l'administrateur)
 public function validateUser($db) {
    // Requête pour mettre à jour l'utilisateur et valider son compte
    $query = "UPDATE user SET is_valid = 1 WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
}

// Méthode pour activer ou désactiver un utilisateur
public function toggleUserActivation($db) {
    // Vérifier l'état actuel de l'utilisateur
    $query = "SELECT is_valid, status FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
    $user = $stmt->fetch();

    // Si l'utilisateur est actuellement activé (is_valid = 1 et status = 'activer')
    if ($user && $user['is_valid'] == 1 && $user['status'] == 'activer') {
        // Désactiver l'utilisateur
        $query = "UPDATE user SET is_valid = 0, status = 'désactiver' WHERE id_user = ?";
    } else {
        // Sinon, activer l'utilisateur
        $query = "UPDATE user SET is_valid = 1, status = 'activer' WHERE id_user = ?";
    }

    // Exécuter la mise à jour
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
}



// Méthode pour récupérer un utilisateur par son ID
public static function getUserById($db, $userId) {
    // Requête pour récupérer l'utilisateur par son ID
    $query = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    
    // Récupérer les données sous forme de tableau associatif
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si des données ont été retournées
    if ($data) {
        // Si des données existent, retourner un objet de type 'user'
        return new self(
            $data['id_user'],
            $data['user_name'],
            $data['user_email'],
            $data['user_password'],
            $data['user_role']
        );
    }
    
    // Retourner null si aucun utilisateur n'a été trouvé
    return null;
}



 // Méthode pour récupérer un utilisateur par son email
 public static function getUserByEmail($db, $email) {
    $query = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetch();
}

// Méthode pour supprimer un utilisateur
public function deleteUser($db) {
    // Requête pour supprimer l'utilisateur par son ID
    $query = "DELETE FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);

    // Vérifier si l'utilisateur a été supprimé avec succès
    if ($stmt->rowCount() > 0) {
        return "Utilisateur supprimé avec succès.";
    } else {
        return "Erreur lors de la suppression de l'utilisateur.";
    }
}

// Méthode pour récupérer les professeurs
public static function getProfesseurs($db) {
    $query = "SELECT * FROM user WHERE user_role = 'enseignant'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(); // Retourne un tableau de tous les enseignants

}


// Méthode pour récupérer tous les utilisateurs
public static function getAllUsers($db) {
    $query = "SELECT * FROM user";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(); // Retourne un tableau de tous les utilisateurs
}

public function inscrireAuCours($db, $id_cours) {
    // Vérifier si l'utilisateur est un étudiant
    if ($this->role_user != 'Etudiant') {
        echo "Seuls les étudiants peuvent s'inscrire aux cours.";
        return;
    }

    // Vérifier si l'étudiant est déjà inscrit à ce cours
    $stmt = $db->prepare('SELECT COUNT(*) FROM inscription WHERE id_user = ? AND id_cours = ?');
    $stmt->execute([$this->id_user, $id_cours]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "Vous êtes déjà inscrit à ce cours.";
        return;
    }

    // Si ce n'est pas le cas, inscrire l'étudiant
    $stmt = $db->prepare('INSERT INTO inscription (id_user, id_cours) VALUES (?, ?)');
    $stmt->execute([$this->id_user, $id_cours]);
    header('Location: ../view/sectionCours.php');

}

}
?>