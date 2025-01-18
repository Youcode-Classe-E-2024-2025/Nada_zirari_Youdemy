<?php
require_once 'config.php'; // Inclut la classe Database
require_once 'Model/Course.php'; // Inclut le modèle des cours

// Initialisation des variables
$limit = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;
$keyword = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '';

// Initialisation de la connexion PDO
$pdo = Database::getInstance()->getConnection();

// Instanciation du modèle CourseModel
$courseModel = new CourseModel($pdo);

// Récupérer les cours
if (!empty($keyword)) {
    $courses = $courseModel->searchCourses($keyword, $limit, $offset);
    $totalCourses = $courseModel->countSearchResults($keyword);
} else {
    $courses = $courseModel->getCourses($limit, $offset);
    $totalCourses = $courseModel->countAllCourses();
}

// Calculer le nombre total de pages
$totalPages = ceil($totalCourses / $limit);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold">Catalogue des cours</h1>
            <form method="GET" action="visiteur.php" class="mt-4 flex">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Rechercher un cours..." 
                    value="<?= htmlspecialchars($keyword) ?>" 
                    class="flex-grow p-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-400"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md"
                >
                    Rechercher
                </button>
            </form>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8">
        <?php if (!empty($courses)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h2 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($course['title']) ?></h2>
                        <p class="text-gray-600 mt-2"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                        <a 
                            href="course.php?id=<?= $course['id'] ?>" 
                            class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                        >
                            Voir le cours
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucun cours trouvé.</p>
        <?php endif; ?>
        <div class="flex justify-center mt-8 space-x-4">
            <?php if ($page > 1): ?>
                <a 
                    href="visiteur.php?page=<?= $page - 1 ?>&search=<?= urlencode($keyword) ?>" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md"
                >
                    Précédent
                </a>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
                <a 
                    href="visiteur.php?page=<?= $page + 1 ?>&search=<?= urlencode($keyword) ?>" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md"
                >
                    Suivant
                </a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
