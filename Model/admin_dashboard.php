<?php
require_once '../config.php';

session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance()->getConnection();

// Récupérer les statistiques globales
try {
    $totalCourses = $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    $categories = $db->query("SELECT name, COUNT(*) AS total FROM categories INNER JOIN courses ON categories.id = courses.category_id GROUP BY categories.name")->fetchAll(PDO::FETCH_ASSOC);
    $mostPopularCourse = $db->query("SELECT courses.title, COUNT(enrollments.id) AS total_students FROM courses INNER JOIN enrollments ON courses.id = enrollments.course_id GROUP BY courses.id ORDER BY total_students DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $topTeachers = $db->query("
    SELECT users.name, COUNT(courses.id) AS total_courses 
    FROM users 
    INNER JOIN courses ON users.id = courses.teacher_id 
    WHERE users.role = 'teacher' 
    GROUP BY users.id 
    ORDER BY total_courses DESC 
    LIMIT 3
")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des statistiques : " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- En-tête -->
    <header class="bg-gray-800 text-white p-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Tableau de bord Administrateur</h1>
            <nav>
                <a href="logout.php" class="text-white hover:underline">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto p-6">
        <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-xl font-semibold mb-4">Validation des comptes enseignants</h2>
            <form method="POST" action="../validate_teacher.php">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Nom</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pendingTeachers = $db->query("
                            SELECT id, name, email 
                            FROM users 
                            WHERE role = 'teacher' AND status = 'pending'
                        ")->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($pendingTeachers as $teacher) {
                            echo "<tr class='hover:bg-gray-50'>";
                            echo "<td class='px-4 py-2 border'>{$teacher['name']}</td>";
                            echo "<td class='px-4 py-2 border'>{$teacher['email']}</td>";
                            echo "<td class='px-4 py-2 border'>
                                    <button type='submit' name='approve' value='{$teacher['id']}' class='bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600'>Valider</button>
                                    <button type='submit' name='reject' value='{$teacher['id']}' class='bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600'>Rejeter</button>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </section>

        <!-- Gestion des utilisateurs -->
        <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des utilisateurs</h2>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Rôle</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $db->query("SELECT id, name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $user) {
                        echo "<tr class='hover:bg-gray-50'>";
                        echo "<td class='px-4 py-2 border'>{$user['name']}</td>";
                        echo "<td class='px-4 py-2 border'>{$user['email']}</td>";
                        echo "<td class='px-4 py-2 border'>{$user['role']}</td>";
                        echo "<td class='px-4 py-2 border'>
                                <a href='suspend_user.php?id={$user['id']}' class='text-yellow-500 hover:underline'>Suspendre</a> | 
                                <a href='delete_user.php?id={$user['id']}' class='text-red-500 hover:underline'>Supprimer</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        
        <!-- Gestion des contenus -->
        <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Ajouter une catégorie</h2>
        <form action="../add_category.php" method="POST" class="flex flex-col">
    <label for="category_name" class="mb-2">Nom de la catégorie :</label>
    <input type="text" id="category_name" name="name" required class="p-2 border border-gray-300 rounded mb-4">
    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Ajouter</button>
</form>


<form action="add_tags.php" method="POST" class="flex flex-col">
    <label for="tags" class="mb-2">Ajouter des tags (séparés par des virgules) :</label>
    <input type="text" id="tags" name="tags" required class="p-2 border border-gray-300 rounded mb-4">
    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Ajouter</button>
</form>

        </section>
<!-- Statistiques globales -->
<section class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold mb-6 text-center">Statistiques globales</h2>

    <!-- Conteneur Flex pour les cartes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Nombre total de cours -->
        <div class="bg-blue-100 p-4 rounded-lg shadow-md">
            <p class="text-lg font-semibold">Nombre total de cours :</p>
            <p class="text-xl font-bold text-blue-600"><?= $totalCourses ?></p>
        </div>

        <!-- Répartition par catégorie -->
        <div class="bg-green-100 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Répartition par catégorie :</h3>
            <ul class="list-disc pl-6 space-y-2">
                <?php
                foreach ($categories as $category) {
                    echo "<li class='text-gray-800'>{$category['name']}: <span class='font-semibold'>{$category['total']}</span> cours</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Cours avec le plus d'étudiants -->
        <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Cours avec le plus d'étudiants :</h3>
            <?php
            if ($mostPopularCourse !== false && isset($mostPopularCourse['title'], $mostPopularCourse['total_students'])) {
                echo "<p class='text-gray-800'>{$mostPopularCourse['title']} (<span class='font-semibold'>{$mostPopularCourse['total_students']}</span> étudiants)</p>";
            } else {
                echo "<p class='text-red-500'>Impossible de récupérer les informations sur le cours le plus populaire.</p>";
            }
            ?>
        </div>

        <!-- Top 3 enseignants -->
        <div class="bg-purple-100 p-4 rounded-lg shadow-md col-span-1 sm:col-span-2 lg:col-span-1">
            <h3 class="text-lg font-semibold mb-2">Top 3 enseignants :</h3>
            <ol class="list-decimal pl-6 space-y-2">
                <?php
                if ($topTeachers !== false && count($topTeachers) > 0) {
                    foreach ($topTeachers as $teacher) {
                        echo "<li class='text-gray-800'>{$teacher['name']} (<span class='font-semibold'>{$teacher['total_courses']}</span> cours)</li>";
                    }
                } else {
                    echo "<li class='text-red-500'>Aucun enseignant trouvé.</li>";
                }
                ?>
            </ol>
        </div>
    </div>
</section>


    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
    </footer>

</body>
</html>
