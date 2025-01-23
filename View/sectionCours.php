<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour voir vos cours.";
    exit;
}

// Obtenir l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Préparer la requête pour récupérer les cours auxquels l'étudiant est inscrit
$query = "SELECT c.id_cours, c.titre_cours, c.desc_cours, c.image_cours
          FROM inscription i
          JOIN cours c ON i.id_cours = c.id_cours
          WHERE i.id_user = :id_user";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
$stmt->execute();

// Récupérer les données des cours
$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Cours</title>
</head>
<body class="bg-gray-200">

    <!-- Barre de navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center">
                <img src="../assets/images/logo.png" alt="Logo" class="w-20">
            </div>
            <div>
                <a href="deconnexion.php" class="text-lg font-bold text-red-600 hover:text-green-500">Log Out</a>
            </div>
            <div>
            <a href="studentInterface.php" class="text-lg font-bold text-pink-800 hover:text-green-500">Retour aux cours principales</a>
            </div>
        </div>
    </nav>
    
    <!-- Contenu des cours -->
    <div class="container mx-auto px-6 py-8 bg-gray-200">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Mes cours</h2>

        <!-- Affichage des cours -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($coursData as $course): ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                    <a href="detailcours.php?id_cours=<?php echo $course['id_cours']; ?>">
                        <img class="w-full h-48 object-cover" src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="Course Image">
                    </a>
                    <div class="p-8">
                        <h5 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($course['titre_cours']); ?></h5>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($course['desc_cours']); ?></p>
                        <div class="flex justify-center">
                            <a href="detailcours.php?id_cour=<?php echo $course['id_cours']; ?>" class="bg-gray-700 text-white font-bold py-2 px-4 rounded hover:bg-green-600"> détail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
