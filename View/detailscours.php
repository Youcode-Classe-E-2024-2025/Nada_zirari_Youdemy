<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require 'vendor/erusev/parsedown/Parsedown.php';

require_once '../config/db.php';
require_once '../model/cours.php';
require_once '../model/categorie.php';

// Vérifier si un ID de cours est passé dans l'URL
if (isset($_GET['id_cour'])) {
    $cours_id = $_GET['id_cour'];

    // Récupérer les détails du cours depuis la base de données
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE id_cours = ?');
    $stmt->execute([$cours_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le cours existe
    if (!$course) {
        die('Cours non trouvé');
    }

    // Déterminer le type de contenu du cours
    $content_type = $course['content_type'];

    // Si le contenu est de type Markdown, le convertir en HTML
    if ($content_type === 'markdown') {
        $parsedown = new Parsedown();
        // Convertir le contenu markdown en HTML
        $course['content_cours'] = $parsedown->text($course['content_cours']);
    }

    $stmt = $pdo->prepare('
    SELECT t.name_tags
    FROM tags t
    JOIN cours_tags ct ON t.id_tags = ct.id_tags
    WHERE ct.id_cours = :id_cours
    ');
    $stmt->execute(['id_cours' => $cours_id]);
     // Récupérer toutes les lignes correspondantes
     $tags = $stmt->fetchAll();
} else {
    die('ID de cours non spécifié');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         body {
            background-color:  #dadfdc;
        }
         /* Style de la barre de navigation */
         .navbar {
            background-color:rgb(255, 255, 255);
            padding: 1rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .navbar a:hover {
            color: #f0a500;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="flex items-center">
            <img src="../assets/images/logo.png" alt="Logo" class="w-12">
        </div>
        <div class="space-x-6 items-center">
        <a href="teacherInterface.php" class="text-center font-bold hover:text-gray-400" style="color:#1c4930">Retour aux cours</a>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6" style="color:#1c4930"><?php echo htmlspecialchars($course['titre_cours']); ?></h1>
        
        <!-- Image du cours -->
        <div class="mb-6">
            <?php if ($course['image_cours']): ?>
                <img src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="Image du cours" class="w-full max-w-3xl mx-auto rounded-lg shadow-md">
            <?php else: ?>
                <p class="text-gray-600 text-center">Aucune image disponible pour ce cours.</p>
            <?php endif; ?>
        </div>
        
        <!-- Description du cours -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2" style="color:#1c4930">Description</h2>
            <p class="text-lg text-gray-700"><?php echo nl2br(htmlspecialchars($course['desc_cours'])); ?></p>
        </div>

         <!-- Description du cours -->
         <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2" style="color:#1c4930">Tags</h2>
            <p class="text-lg text-gray-700"><?php  foreach ($tags as $tag) {
        echo " - " . $tag['name_tags'];
    }?></p>
        </div>
        <!-- Contenu du cours en fonction du type -->
        <div class="mb-6">
            <?php if ($content_type === 'markdown'): ?>
                <h2 class="text-2xl font-bold mb-2" style="color:#1c4930">Contenu du cours</h2>
                <div class="prose max-w-none">
                    <!-- Affichage du contenu Markdown converti en HTML -->
                    <?php echo $course['content_cours']; ?>
                </div>
            <?php elseif ($content_type === 'video'): ?>
                <h2 class="text-2xl font-semibold mb-2" style="color:#1c4930">Vidéo du cours</h2>
                <div class="flex justify-center">
                    <video controls class="w-full max-w-3xl rounded-lg shadow-md">
                        <source src="<?php echo htmlspecialchars($course['content_cours']); ?>" type="video/mp4">
                        Votre navigateur ne prend pas en charge la vidéo.
                    </video>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
