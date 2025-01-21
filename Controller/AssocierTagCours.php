<?php
// Inclure le fichier de connexion à la base de données et les classes nécessaires
require_once '../config/db.php';
require_once '../model/cours.php'; // Assurez-vous que le chemin est correct

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer l'ID du cours sélectionné et les tags associés
    $id_cours = $_POST['id_categorie'];  // Vous devez envoyer l'ID du cours à associer
    $tags = isset($_POST['tags']) ? $_POST['tags'] : []; // Récupérer les tags sélectionnés

    // Vérifier que l'ID du cours et les tags sont valides
    if ($id_cours && !empty($tags)) {
        try {
            // Récupérer les informations du cours depuis la base de données
            $stmt = $pdo->prepare('SELECT * FROM cours WHERE id_cours = ?');
            $stmt->execute([$id_cours]);
            $coursData = $stmt->fetch();

            if ($coursData) {
                // Créer une instance de la classe Cours (selon le type de contenu)
                $cours = new CoursMarkdown($coursData['titre_cours'], $coursData['desc_cours'], 
                                           $coursData['content_type'], $coursData['content_cours'], 
                                           $coursData['id_user'], $coursData['id_categorie'], 
                                           $coursData['image_cours'], $coursData['id_cours']);
                
                // Assigner les tags au cours
                $cours->assignerTags($pdo, $tags);
                
                // Rediriger ou afficher un message de succès
                echo "Les tags ont été associés avec succès au cours.";
            } else {
                echo "Cours introuvable.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez sélectionner un cours et au moins un tag.";
    }
}
?>
