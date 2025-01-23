<?php
// Inclure le fichier de connexion à la base de données
require_once '../config/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    echo "Vous devez être connecté";
    exit;
}

$id_user = $_SESSION['user_id'];  // Récupérer l'ID de l'utilisateur (professeur)

// Requête pour compter le nombre d'étudiants inscrits aux cours de ce professeur
$stmt = $pdo->prepare('
    SELECT COUNT(DISTINCT i.id_user) AS total_etudiants 
    FROM inscription i
    JOIN cours c ON i.id_cours = c.id_cours
    WHERE c.id_user = ?
');
$stmt->execute([$id_user]);
$resultat = $stmt->fetch();
$totalEtudiants = $resultat['total_etudiants'];

// Requête pour compter le nombre de cours créés par le professeur
$stmt = $pdo->prepare('SELECT COUNT(*) AS total_cours FROM cours WHERE id_user = ?');
$stmt->execute([$id_user]);
$resultat = $stmt->fetch();
$totalCours = $resultat['total_cours'];

// Nombre total d'étudiants inscrits dans tous les cours
$query_etudiants = "SELECT COUNT(DISTINCT id_user) AS total_etudiants FROM inscription";
$result_etudiants = $pdo->query($query_etudiants);
$total_etudiants = $result_etudiants->fetch()['total_etudiants'];

// Nombre total de cours dans tous les cours
$query_cours = "SELECT COUNT(*) AS total_cours FROM cours";
$result_cours = $pdo->query($query_cours);
$total_cours = $result_cours->fetch()['total_cours'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Cours et Étudiants</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
        body {
            background-color:  #dadfdc;
        }
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
    <!-- Barre de navigation -->
    <nav class="navbar">
        <div class="flex items-center">
            <img src="../assets/images/logo.png" alt="Logo" class="w-12">
        </div>
        <h2 class="text-center text-2xl font-bold mt-[20px]" style="color:rgb(100, 43, 66)">Statistiques Cours et Étudiants</h2>
        <div class="space-x-6 items-center">
            <a href="teacherInterface.php" class="text-center font-bold hover:text-gray-400" style="color:#1c4930">Retour aux cours</a>
        </div>
    </nav>

    <!-- Statistiques -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
        <div class="bg-yellow-200 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h2 class="font-bold uppercase text-gray-600">Nombre total de cours </h2>
                    <p><?php echo $totalCours . ' cours'; ?></p>
                    <h2 class="font-bold uppercase text-gray-600 mt-2">Nombre total d'étudiants inscrits </h2>
                    <p><?php echo $totalEtudiants . ' étudiants'; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques globales -->
     <!-- <div class="w-full md:w-1/2 xl:w-1/3 p-6">
        <div class="bg-green-200 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-green-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h2 class="font-bold uppercase text-gray-600">Nombre total de cours (Global)</h2>
                    <p><?php echo $total_cours . ' cours'; ?></p>
                    <h2 class="font-bold uppercase text-gray-600 mt-2">Nombre total d'étudiants inscrits (Global)</h2>
                    <p><?php echo $total_etudiants . ' étudiants'; ?></p>
                </div>
            </div>
        </div> 
    </div> -->
</body>
</html>
