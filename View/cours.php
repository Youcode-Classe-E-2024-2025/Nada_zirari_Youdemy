<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier

// Paramètres pour la pagination
$limit = 12; // Nombre de cours par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Gestion de la recherche
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construire la requête avec la recherche
$query = "SELECT * FROM cours WHERE titre_cours LIKE :search LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%'.$searchTerm.'%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total de pages
$totalQuery = "SELECT COUNT(*) FROM cours WHERE titre_cours LIKE :search";
$stmtTotal = $pdo->prepare($totalQuery);
$stmtTotal->bindValue(':search', '%'.$searchTerm.'%', PDO::PARAM_STR);
$stmtTotal->execute();
$totalCours = $stmtTotal->fetchColumn();
$totalPages = ceil($totalCours / $limit);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dadfdc;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    
    <!-- Header -->
   <?php 
   include_once 'header.php';
   ?>


    <!-- Formulaire de recherche -->
    <div class="container mx-auto px-4 py-4 mt-24">
        <form method="GET" action="Cours.php">
            <input type="text" name="search" class="p-2 border rounded w-[30%]" placeholder="Rechercher un cours par titre..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="p-2 ml-2 text-white rounded" style="background-color:#1c4933;">Rechercher</button>
        </form>
    </div>

    <!-- Affichage des cours -->
    <div class="main-content container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach ($coursData as $course): ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a>
                        <img class="rounded-t-lg" src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="" />
                    </a>
                    <div class="p-5">
                        <a>
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="color:#24508c"><?php echo htmlspecialchars($course['titre_cours']); ?></h5>
                        </a>
                        <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo htmlspecialchars($course['desc_cours']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pagination -->
    <div class="container mx-auto px-4 py-4 text-center">
        <div class="flex justify-center space-x-2">
            <?php if ($page > 1): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page - 1; ?>" class="px-4 py-2 bg-green-900 text-white rounded">Précédent</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>" class="px-4 py-2 <?php echo $i == $page ? 'bg-green-900 text-white' : 'bg-gray-300 text-gray-800'; ?> rounded"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-green-900 text-white rounded">Suivant</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
