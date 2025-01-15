<?php
session_start();
require_once './config.php';
// require_once 'classes/Database.php';
// require_once '../classes/Stats.php';

// Vérification du rôle d'administrateur
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
$database = Database::getInstance();
$conn = $database->getConnection();

// Récupération des statistiques
$stats = new Stats($conn);
$totalCourses = $stats->getTotalCourses();
$categoryDistribution = $stats->getCategoryDistribution();
$topCourse = $stats->getTopCourse();
$topTeachers = $stats->getTopTeachers();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans">

<!-- Wrapper -->
<div class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-800 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-2xl font-bold">Youdemy - Statistiques</h1>
            <nav class="flex space-x-4">
                <a href="admin_dashboard.php" class="hover:text-gray-300">Tableau de bord</a>
                <a href="admin_users.php" class="hover:text-gray-300">Utilisateurs</a>
                <a href="admin_courses.php" class="hover:text-gray-300">Cours</a>
                <a href="../logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-green-700">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto flex-1 py-10 px-6">
        <!-- Statistiques Globales -->
        <section class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Statistiques Globales</h2>
            
            <!-- Total Courses -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Nombre Total de Cours</h3>
                <p class="text-gray-600"><?= $totalCourses ?></p>
            </div>

            <!-- Répartition des Cours par Catégorie -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Répartition des Cours par Catégorie</h3>
                <canvas id="categoryChart"></canvas>
            </div>

            <!-- Cours avec le Plus d'Étudiants -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Cours avec le Plus d'Étudiants</h3>
                <p class="text-gray-600"><?= htmlspecialchars($topCourse['title']) ?> (<?= $topCourse['student_count'] ?> étudiants)</p>
            </div>

            <!-- Top 3 Enseignants -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Top 3 Enseignants</h3>
                <ul class="list-disc pl-6">
                    <?php foreach ($topTeachers as $teacher): ?>
                        <li class="text-gray-600"><?= htmlspecialchars($teacher['name']) ?> (<?= $teacher['course_count'] ?> cours)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
        </div>
    </footer>

</div>

<script>
// Chart.js - Répartition des Cours par Catégorie
var ctx = document.getElementById('categoryChart').getContext('2d');
var categoryChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(array_keys($categoryDistribution)); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($categoryDistribution)); ?>,
            backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#9C27B0', '#FF5722'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw + ' cours';
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>
