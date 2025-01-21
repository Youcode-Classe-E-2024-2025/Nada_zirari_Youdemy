<?php
// controller/TagController.php

require_once '../config/db.php';
require_once '../model/tag.php';  // Inclusion du modèle Tag

// Traitement de l'ajout de tags via formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées (tags en format JSON)
    if (isset($_POST['tags'])) {
        $tagsJson = $_POST['tags'];
        $tags = json_decode($tagsJson, true); // Convertir le JSON en tableau PHP

        if (is_array($tags) && !empty($tags)) {
            // Démarrer une transaction pour garantir l'intégrité des données
            $pdo->beginTransaction();

            try {
                // 1. Insérer ou mettre à jour les tags dans la table 'tags'
                foreach ($tags as $tag) {
                    if (!empty($tag['value'])) { // Vérifier que le champ 'value' n'est pas vide
                        $tagName = trim($tag['value']); // Enlever les espaces inutiles

                        // Créer ou mettre à jour le tag
                        $tagObj = new Tag($pdo, $tagName);
                        $tagObj->save(); // Insertion ou mise à jour du tag
                    }
                }

                // 2. Associations des tags à un cours ou à un autre objet (si nécessaire)
                // Exemple : association avec un cours

                // $stmt = $pdo->prepare("SELECT id_tags FROM tags WHERE name_tags IN ('" . implode("', '", array_map('trim', array_column($tags, 'value'))) . "')");
                // $stmt->execute();
                // $tag_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // // Associating tags with the course
                // foreach ($tag_ids as $tag_id) {
                //     $stmt = $pdo->prepare("INSERT INTO cours_tags (id_cours, id_tags) VALUES (:id_cours, :id_tags)");
                //     $stmt->execute([':id_cours' => $cours_id, ':id_tags' => $tag_id]);
                // }

                // Commit de la transaction
                $pdo->commit();
                echo "Tags associés au cours avec succès.";
            } catch (Exception $e) {
                // En cas d'erreur, annuler la transaction
                $pdo->rollBack();
                echo "Erreur lors de l'insertion des tags : " . $e->getMessage();
            }
        } else {
            echo "Aucun tag valide n'a été envoyé.";
        }
    } else {
        echo "Aucun tag n'a été envoyé.";
    }
}

// Traitement de la suppression d'un tag
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['deleteTagId'])) {
    try {
        $tagId = $_GET['deleteTagId'];
        $tag = Tag::getById($pdo, $tagId);
        if ($tag) {
            $tag->delete(); // Suppression du tag
            echo "Tag supprimé avec succès.";
        } else {
            echo "Tag non trouvé.";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la suppression du tag : " . $e->getMessage();
    }
}
?>
