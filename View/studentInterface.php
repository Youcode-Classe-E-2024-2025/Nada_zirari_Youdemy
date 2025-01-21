<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier
session_start();
if(!isset($_SESSION['user_id'])){
    echo "vous devez etre connecter";
    exit;
}
$stmt = $pdo->query("SELECT * FROM cours");
$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <title>Cours</title>
    <style>
         /* Le modal sera placé au-dessus du contenu avec un fond semi-transparent */
         #modal, #modal-assigner {
            display: none; /* Initialement caché */
            position: fixed; /* Pour qu'il soit fixé en haut de la page */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
            z-index: 50; /* Placer le modal au-dessus du contenu */
            justify-content: center;
            align-items: center;
            overflow-y: auto; /* Permet le défilement si le contenu est trop long */
        }

        /* Contenu du modal */
        .modal-content {
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 90vh; /* Limiter la hauteur du modal */
            overflow-y: auto; /* Activer le défilement vertical à l'intérieur du modal */
        }
        
        body {
            background-color: #dadfdc;
            overflow-y: auto;
        }

        /* Style du menu */
        .menu {
            display: none; /* Initialement caché */
            position: absolute;
            top: 60px; /* Place le menu juste en dessous de l'icône */
            right: 65px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 5px;
            width: 150px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10; /* Assure que le menu est au-dessus des autres éléments */
        }

        /* Style des éléments de menu */
        .menu a {
            display: block;
            background-color: #dadfdc;
            margin-top: 2px;
            color: #333;
            text-decoration: none;
        }

        .menu a:hover {
            background-color: #dadfdc;
            cursor: pointer;
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
    <!-- Barre de navigation -->
    <nav class="navbar">
        <div class="flex items-center">
            <img src="../assets/images/logo.png" alt="Logo" class="w-12">
        </div>
        <div class="space-x-6 items-center">
            <a href="deconnexion.php" class="text-center font-bold hover:text-gray-400" style="color:#1c4933">log out</a> 
        </div>
    </nav>

    <!-- Contenu des cours -->
    <div class="container px-4">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold mb-4" style="color:#1c4933">Tout les cours</h2>
            <div class="flex justify-center gap-5 my-4">
                <a href="sectionCours.php" style="color: #dadfdc ;background-color:#1c4933;" class="text-white font-bold py-2 px-3 rounded hover:bg-red-600">Mes cours</a>
            </div>
        </div>

        <!-- Affichage des cours -->
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($coursData as $course): ?>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="taches_view.php?id_cours=<?php echo $course['id_cours']; ?>">
                            <img class="rounded-t-lg" src="<?php echo htmlspecialchars($course['image_cours']); ?>" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="color:#1c4930"><?php echo htmlspecialchars($course['titre_cours']); ?></h5>
                            </a>
                            <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo htmlspecialchars($course['desc_cours']); ?></p> 
                            <form class="inline ml-1 flex justify-center" action="../controller/courInscription.php" method="POST">
                                <input type="hidden"  name="id_cours" value="<?php echo $course['id_cours']; ?>">
                               <button type="submit" style="color: rgb(187, 214, 211) ;background-color:#1c4930;"  class="text-white text-center font-bold px-2 rounded hover:bg-red-600 w-32 h-12">Inscription</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

       
    </div>

 

</body>
</html>
