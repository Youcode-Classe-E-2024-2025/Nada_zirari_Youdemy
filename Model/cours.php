<?php
// Inclure le fichier de connexion à la base de données
require_once '../config/db.php';

abstract class Cours {
    private $id_cours;
    private $titre_cours;
    private $image_cours;
    private $desc_cours;
    private $content_type;
    private $content_cours;
    private $id_user;  // Identifiant du professeur
    private $id_categorie;  // Identifiant de la catégorie

    // Constructeur
    public function __construct($titre_cours, $desc_cours, $content_type, $content_cours, $id_user, $id_categorie, $image_cours = null, $id_cours = null) {
        $this->id_cours = $id_cours;
        $this->titre_cours = $titre_cours;
        $this->image_cours = $image_cours;
        $this->desc_cours = $desc_cours;
        $this->content_type = $content_type;
        $this->content_cours = $content_cours;
        $this->id_user = $id_user;
        $this->id_categorie = $id_categorie;
    }

    // Getters
    public function getIdCours() { return $this->id_cours; }
    public function getTitreCours() { return $this->titre_cours; }
    public function getImageCours() { return $this->image_cours; }
    public function getDescCours() { return $this->desc_cours; }
    public function getContentType() { return $this->content_type; }
    public function getContentCours() { return $this->content_cours; }
    public function getIdUser() { return $this->id_user; }
    public function getIdCategorie() { return $this->id_categorie; }

    // Setters
    public function setTitreCours($titre_cours) { $this->titre_cours = $titre_cours; }
    public function setImageCours($image_cours) { $this->image_cours = $image_cours; }
    public function setDescCours($desc_cours) { $this->desc_cours = $desc_cours; }
    public function setContentType($content_type) { $this->content_type = $content_type; }
    public function setContentCours($content_cours) { $this->content_cours = $content_cours; }
    public function setIdUser($id_user) { $this->id_user = $id_user; }
    public function setIdCategorie($id_categorie) { $this->id_categorie = $id_categorie; }

    // Méthode abstraite pour ajouter un cours en fonction du type de contenu
    abstract public function ajouterCours($db);

    // Méthode abstraite pour afficher un cours en fonction du type de contenu
    abstract public function afficherCours($db);

    // Méthode pour modifier un cours existant (validation du professeur)
    public function modifierCours($db) {
        if ($this->getIdCours() !== null) {
            $stmt = $db->prepare('SELECT id_user FROM cours WHERE id_cours = ?');
            $stmt->execute([$this->getIdCours()]);
            $cours = $stmt->fetch();

            if ($cours['id_user'] === $this->getIdUser()) {  // Vérifier que le cours appartient bien au professeur
                $stmt = $db->prepare('UPDATE cours SET titre_cours = ?, image_cours = ?, desc_cours = ?, content_type = ?, content_cours = ?, id_categorie = ? WHERE id_cours = ?');
                $stmt->execute([
                    $this->getTitreCours(),
                    $this->getImageCours(),
                    $this->getDescCours(),
                    $this->getContentType(),
                    $this->getContentCours(),
                    $this->getIdCategorie(),
                    $this->getIdCours()
                ]);
            } else {
                echo "Vous n'êtes pas autorisé à modifier ce cours.";
            }
        }
    }

    // Méthode pour supprimer un cours (validation du professeur)
    public function supprimerCours($db) {
        if ($this->getIdCours() !== null) {
            $stmt = $db->prepare('SELECT id_user FROM cours WHERE id_cours = ?');
            $stmt->execute([$this->getIdCours()]);
            $cours = $stmt->fetch();
    
            if ($cours['id_user'] === $this->getIdUser()) {  // Vérifier que le cours appartient bien au professeur
                $stmt = $db->prepare('DELETE FROM cours WHERE id_cours = ?');
                $stmt->execute([$this->getIdCours()]);
            } else {
                echo "Vous n'êtes pas autorisé à supprimer ce cours.";
            }
        }
    }
    
        // Méthode pour assigner des tags à un cours
        public function assignerTags($db, $tags) {
            if ($this->getIdCours() !== null) {
                // Supprimer les anciens tags avant d'ajouter les nouveaux (si nécessaire)
                $stmt = $db->prepare('DELETE FROM cours_tags WHERE id_cours = ?');
                $stmt->execute([$this->getIdCours()]);
    
                // Ajouter les nouveaux tags
                foreach ($tags as $tagId) {
                    $stmt = $db->prepare('INSERT INTO cours_tags (id_cours, id_tags) VALUES (?, ?)');
                    $stmt->execute([$this->getIdCours(), $tagId]);
                }
                echo "Tags assignés avec succès au cours.";
            } else {
                echo "Le cours n'existe pas.";
            }
        }    
    

    
        
}

class CoursMarkdown extends Cours {
    public function ajouterCours($db) {
        $stmt = $db->prepare('INSERT INTO cours (titre_cours, image_cours, desc_cours, content_type, content_cours, id_user, id_categorie) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $this->getTitreCours(),
            $this->getImageCours(),
            $this->getDescCours(),
            'markdown',
            $this->getContentCours(),
            $this->getIdUser(),
            $this->getIdCategorie()
        ]);
        $this->id_cours = $db->lastInsertId(); // Récupérer l'ID généré
    }

    public function afficherCours($db) {
        echo "<div class='markdown-content'>" . nl2br(htmlspecialchars($this->getContentCours())) . "</div>";
    }
}

class CoursVideo extends Cours {
    public function ajouterCours($db) {
        $stmt = $db->prepare('INSERT INTO cours (titre_cours, image_cours, desc_cours, content_type, content_cours, id_user, id_categorie) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $this->getTitreCours(),
            $this->getImageCours(),
            $this->getDescCours(),
            'video',
            $this->getContentCours(), // URL de la vidéo
            $this->getIdUser(),
            $this->getIdCategorie()
        ]);
        $this->id_cours = $db->lastInsertId(); // Récupérer l'ID généré
    }

    public function afficherCours($db) {
        echo "<div class='video-content'>
                <video controls>
                    <source src='" . htmlspecialchars($this->getContentCours()) . "' type='video/mp4'>
                    Votre navigateur ne supporte pas la vidéo.
                </video>
              </div>";
    }
}

?>
