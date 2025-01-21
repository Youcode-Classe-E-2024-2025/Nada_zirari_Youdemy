<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php';

// Vérifier si un ID de cours est passé dans l'URL
if (isset($_GET['id_cour'])) {
    $cours_id = $_GET['id_cour'];

    // Récupérer les détails du cours pour pré-remplir le formulaire
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE id_cours = ?');
    $stmt->execute([$cours_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le cours existe
    if (!$course) {
        die('Cours non trouvé');
    }

    // Déterminer le type de contenu du cours
    $content_type = $course['content_type'];
} else {
    die('ID de cours non spécifié');
}

// Initialiser les variables du formulaire
$titre = $image_cours = $description = $content_cours = '';
$file_error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $titre = isset($_POST['title']) ? $_POST['title'] : '';
    $image_cours = isset($_POST['image_cours']) ? $_POST['image_cours'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $content_cours = isset($_POST['content_cours']) ? $_POST['content_cours'] : '';

    // Si le type de contenu est vidéo, vérifier le fichier uploadé
    if ($content_type === 'video') {
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === 0) {
            // Vérifier si le fichier téléchargé est une vidéo
            $allowed_extensions = ['mp4', 'webm', 'ogg'];
            $file_extension = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_extensions)) {
                $file_error = "Seuls les fichiers vidéo (mp4, webm, ogg) sont autorisés.";
            } else {
                // Déplacer le fichier vidéo vers le répertoire des vidéos
                $target_dir = "../uploads/videos/";
                $new_video_name = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_video_name;
                move_uploaded_file($_FILES['video_file']['tmp_name'], $target_file);

                // Mettre à jour l'URL de la vidéo dans le contenu
                $content_cours = $target_file; // Mise à jour du chemin de la vidéo
            }
        }
    }

    // Vérification si les champs obligatoires sont remplis
    if (empty($titre) || empty($description) || empty($content_cours)) {
        $error_message = "Tous les champs obligatoires doivent être remplis.";
    } else {
        // Créer un objet Cours avec les nouvelles données
        if ($content_type === 'markdown') {
            $cours = new CoursMarkdown($titre, $description, 'markdown', $content_cours, $image_cours, $cours_id);
        } else {
            $cours = new CoursVideo($titre, $description, 'video', $content_cours, $image_cours, $cours_id);
        }

        // Mettre à jour le cours dans la base de données
        try {
            $cours->modifierCours($pdo);
            $success_message = "Cours mis à jour avec succès.";
        } catch (Exception $e) {
            $error_message = "Erreur lors de la mise à jour du cours: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Ajouter le CDN de SimpleMDE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplemde@1.11.2/dist/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/simplemde@1.11.2/dist/simplemde.min.js"></script>
</head>
<body>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Modifier le Cours</h2>

        <!-- Afficher les messages d'erreur ou de succès -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <?php echo $error_message; ?>
            </div>
        <?php elseif (isset($success_message)): ?>
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($file_error)): ?>
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <?php echo $file_error; ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de modification -->
        <form action="modifier_cours.php?id_cour=<?php echo $cours_id; ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Titre du cours</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded mt-2" value="<?php echo htmlspecialchars($course['titre_cours']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="image_cours" class="block text-gray-700 font-medium">Image du cours (optionnelle)</label>
                <input type="text" id="image_cours" name="image_cours" class="w-full p-2 border border-gray-300 rounded mt-2" value="<?php echo htmlspecialchars($course['image_cours']); ?>">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Description du cours</label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded mt-2" required><?php echo htmlspecialchars($course['desc_cours']); ?></textarea>
            </div>

            <!-- Si le type de contenu est 'markdown' -->
            <?php if ($content_type === 'markdown'): ?>
                <div class="mb-4">
                    <label for="content_cours" class="block text-gray-700 font-medium">Contenu du cours (Markdown)</label>
                    <!-- Utiliser SimpleMDE pour l'édition Markdown -->
                    <textarea id="content_cours" name="content_cours" class="w-full p-2 border border-gray-300 rounded mt-2"><?php echo htmlspecialchars($course['content_cours']); ?></textarea>
                </div>
            <?php endif; ?>

            <!-- Si le type de contenu est 'video' -->
            <?php if ($content_type === 'video'): ?>
                <div class="mb-4">
                    <label for="content_cours" class="block text-gray-700 font-medium">URL actuelle de la vidéo</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded mt-2" value="<?php echo htmlspecialchars($course['content_cours']); ?>" disabled>
                </div>
                <div class="mb-4">
                    <label for="video_file" class="block text-gray-700 font-medium">Télécharger une nouvelle vidéo</label>
                    <input type="file" name="video_file" id="video_file" class="w-full p-2 border border-gray-300 rounded mt-2">
                </div>
            <?php endif; ?>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Mettre à jour</button>
            </div>
        </form>
    </div>

    <!-- Initialiser SimpleMDE pour le champ Markdown -->
    <script>
        var simplemde = new SimpleMDE({
            element: document.getElementById("content_cours"),
            spellChecker: false
        });
    </script>
</body>
</html>
