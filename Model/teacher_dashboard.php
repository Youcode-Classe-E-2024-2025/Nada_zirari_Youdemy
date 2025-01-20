<?php
session_start();
require_once '../config.php';
require_once '../classes/Course.php';
require_once '../classes/Auth.php';

// Vérification de rôle
Auth::checkRole('teacher');

$course = new Course();
$teacherId = $_SESSION['user_id'];

// Récupérer les cours
$courses = $course->getCoursesByTeacher($teacherId);
// Connexion à la base de données
$database = Database::getInstance();
$conn = $database->getConnection();
// Récupérer les tags existants
$stmtTags = $conn->prepare("SELECT * FROM tags");
$stmtTags->execute();
$tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);



// Récupérer les cours de l'enseignant connecté
$teacher_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
$stmt->bindParam(':teacher_id', $teacher_id);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nombre de cours
$stmtCoursesCount = $conn->prepare("SELECT COUNT(*) AS course_count FROM courses WHERE teacher_id = :teacher_id");
$stmtCoursesCount->bindParam(':teacher_id', $teacherId);
$stmtCoursesCount->execute();
$courseCount = $stmtCoursesCount->fetch(PDO::FETCH_ASSOC)['course_count'];

// Récupérer le nombre d'étudiants inscrits
// Récupérer le nombre d'étudiants inscrits
$stmtStudentsCount = $conn->prepare("SELECT COUNT(DISTINCT user_id) AS student_count FROM enrollments WHERE course_id IN (SELECT id FROM courses WHERE teacher_id = :teacher_id)");
$stmtStudentsCount->bindParam(':teacher_id', $teacherId);
$stmtStudentsCount->execute();
$studentCount = $stmtStudentsCount->fetch(PDO::FETCH_ASSOC)['student_count'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord - Enseignant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

  <!-- Wrapper -->
  <!-- <div class="min-h-screen flex flex-col"> -->

    <!-- Header -->
    <header class="bg-gray-800 text-white shadow-md">
      <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <h1 class="text-2xl font-bold">Youdemy</h1>
        <nav class="flex space-x-4">
          <a href="#" class="hover:text-gray-300">Accueil</a>
          <a href="#courses" class="hover:text-gray-300">Mes cours</a>
          <a href="#" class="hover:text-gray-300">Statistiques</a>
          <a href="../logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-green-700">Déconnexion</a>
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto flex-1 py-10 px-6">
      <!-- Welcome Section -->
      <section class="mb-8">
        <h2 class="text-3xl font-semibold text-gray-800">Bienvenue, Enseignant !</h2>
        <p class="text-gray-600 mt-2">Gérez vos cours, ajoutez-en de nouveaux et consultez vos statistiques.</p>
      </section>

      <!-- Actions Section -->
      <!-- <section class="mb-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> -->
        <!-- Ajouter un cours -->
        <!-- <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Ajouter un cours</h3>
          <p class="text-gray-600 mb-6">Créez un nouveau cours avec des détails complets pour vos étudiants.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</a>
        </div> -->

        <!-- Mes cours -->
        <!-- <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Mes cours</h3>
          <p class="text-gray-600 mb-6">Consultez et gérez les cours que vous avez créés.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Voir</a>
        </div> -->
<!-- </div> -->
        <!-- Statistiques -->
        <!-- <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Statistiques</h3>
          <p class="text-gray-600 mb-6">Analysez les performances de vos cours et l'engagement des étudiants.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Consulter</a>
        </div>
      </section> -->
      <!-- Statistiques -->
      <section id="stat"  class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
      
  <h3 class="text-xl font-semibold text-gray-800 mb-4">Statistiques</h3>
  <p class="text-gray-600 mb-6">Analysez les performances de vos cours et l'engagement des étudiants.</p>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Nombre de cours -->
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
      <h4 class="text-2xl font-semibold mb-4">Nombre de cours</h4>
      <p class="text-lg"><?= $courseCount ?></p>
    </div>

    <!-- Nombre d'étudiants inscrits -->
    <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
      <h4 class="text-2xl font-semibold mb-4">Nombre d'étudiants inscrits</h4>
      <p class="text-lg"><?= $studentCount ?></p>
    </div>

    <!-- Autres statistiques (ajoutez d'autres statistiques ici si nécessaire) -->
    <div class="bg-yellow-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
      <h4 class="text-2xl font-semibold mb-4">Autre Statistique</h4>
      <p class="text-lg">Données supplémentaires ici</p>
    </div>
  </div>

  <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-6 inline-block">Consulter</a>

</section>


      <!-- Liste des cours -->
         <!-- Liste des cours -->
         <section id="courses" class="mb-10">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Mes cours</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="../cours-en-ligne.png" alt="Cours" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="text-lg font-bold"><?= htmlspecialchars($course['title']) ?></h4>
                            <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($course['description']) ?></p>
                            <div class="flex justify-between">
                                <a href="edit_course.php?id=<?= $course['id'] ?>" class="text-blue-600 hover:underline">Modifier</a>
                                <a href="delete_course.php?id=<?= $course['id'] ?>" class="text-red-600 hover:underline">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

<!-- //modal add cours -->
 <!-- Ajouter un cours -->
 <section class="mb-10 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Ajouter un cours</h3>
            <form action="add_cours.php" method="POST" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre du cours</label>
                    <input type="text" id="title" name="title" required
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" required
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
                    <textarea id="content" name="content" required
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <input type="text" id="category" name="category"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                  
    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
    <div class="mt-2 space-y-2">
        <?php foreach ($tags as $tag): ?>
            <div class="flex items-center">
                <input type="checkbox" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>"
                       class="mr-2">
                       <label for="tag_<?= $tag['id'] ?>" class="text-sm text-gray-700">
    <?= isset($tag['name']) ? htmlspecialchars($tag['name']) : 'Tag non défini' ?>
</label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

                <button type="submit"
                        class="w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                    Ajouter le cours
                </button>
            </form>
        </section>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
      <div class="container mx-auto text-center">
        <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
      </div>
    </footer>

  </div>

</body>
</html>
