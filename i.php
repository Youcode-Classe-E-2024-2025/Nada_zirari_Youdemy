
<?php
require_once 'config.php'; 
require_once 'classes/course.php'; 

// Inclut la classe Database
// require_once 'Model/Course.php'; // Inclut le modèle des cours

// Initialisation des variables
$limit = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;
$keyword = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '';

// Initialisation de la connexion PDO
$pdo = Database::getInstance()->getConnection();

// Instanciation du modèle CourseModel
$course = new course($pdo);

// Récupérer les cours
if (!empty($keyword)) {
    $courses = $course->searchCourses($keyword, $limit, $offset);
    $totalCourses = $course->countSearchResults($keyword);
} else {
    $courses = $course->getCourses($limit, $offset);
    $totalCourses = $course->countAllCourses();
}

// Calculer le nombre total de pages
$totalPages = ceil($totalCourses / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Learn Anytime, Anywhere</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  <!-- Header -->
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

  <!-- Hero Section -->
  <section class="bg-cover bg-center h-screen" style="background-image: url('https://via.placeholder.com/1920x1080');">
    <div class="bg-black bg-opacity-50 h-full flex items-center justify-center text-center">
      <div class="text-white px-6">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Learn Anytime, Anywhere</h1>
        <p class="text-lg md:text-2xl mb-6">Join Youdemy and unlock your potential with thousands of online courses.</p>
        <a href="Signup.php" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">JOIN US</a>
      </div>
    </div>
  </section>

 
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
<!-- 
  <!-- Popular Courses Section -->
  <!-- <section class="py-16">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-8">Popular Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-4 shadow rounded">
          <img src="https://via.placeholder.com/300" alt="Course 1" class="w-full h-48 object-cover rounded mb-4">
          <h3 class="text-xl font-semibold">Web Development</h3>
          <p class="text-gray-600">Learn the latest web technologies.</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <img src="https://via.placeholder.com/300" alt="Course 2" class="w-full h-48 object-cover rounded mb-4">
          <h3 class="text-xl font-semibold">Digital Marketing</h3>
          <p class="text-gray-600">Master online marketing strategies.</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <img src="https://via.placeholder.com/300" alt="Course 3" class="w-full h-48 object-cover rounded mb-4">
          <h3 class="text-xl font-semibold">Graphic Design</h3>
          <p class="text-gray-600">Create stunning visuals and designs.</p>
        </div>
      </div>
    </div>
  </section> --> -->

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto px-6 text-center">
      <p>&copy; 2025 Youdemy. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>