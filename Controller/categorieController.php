<?php 
// controller/CategoryController.php

require_once '../config/db.php';
require_once '../model/Categorie.php';  // Inclusion du modèle Category

// Traitement de l'ajout de catégories via formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées (catégories en format JSON)
    if (isset($_POST['categories'])) {
        $categoriesJson = $_POST['categories'];
        $categories = json_decode($categoriesJson, true); // Convertir le JSON en tableau PHP

        if (is_array($categories) && !empty($categories)) {
            // Démarrer une transaction pour garantir l'intégrité des données
            $pdo->beginTransaction();

            try {
                // 1. Insérer ou mettre à jour les catégories dans la table 'categories'
                foreach ($categories as $category) {
                    if (!empty($category['value'])) { // Vérifier que le champ 'value' n'est pas vide
                        $categoryName = trim($category['value']); // Enlever les espaces inutiles

                        // Créer ou mettre à jour la catégorie
                        $categoryObj = new Category($pdo, $categoryName);
                        $categoryObj->save(); // Insertion ou mise à jour de la catégorie
                    }
                }

                // Commit de la transaction
                $pdo->commit();
                echo "Catégories ajoutées avec succès.";
            } catch (Exception $e) {
                // En cas d'erreur, annuler la transaction
                $pdo->rollBack();
                echo "Erreur lors de l'ajout des catégories : " . $e->getMessage();
            }
        } else {
            echo "Aucune catégorie valide n'a été envoyée.";
        }
    } else {
        echo "Aucune catégorie n'a été envoyée.";
    }
}

// Traitement de la suppression d'une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['deleteCategoryId'])) {
    try {
        $categoryId = $_GET['deleteCategoryId'];
        $category = Category::getById($pdo, $categoryId);
        if ($category) {
            $category->delete(); // Suppression de la catégorie
            echo "Catégorie supprimée avec succès.";
        } else {
            echo "Catégorie non trouvée.";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
    }
}
?>
