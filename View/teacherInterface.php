<?php
// Inclure le fichier de connexion à la base de données et les classes de cours
require_once '../config/db.php';
require_once '../model/cours.php'; // Assure-toi d'inclure ce fichier
session_start();
if(!isset($_SESSION['user_id'])){
    echo "vous devez etre connecter";
    exit;
}
$id_user = $_SESSION['user_id'];  // Récupérer l'ID de l'utilisateur (professeur)

// Récupérer tous les cours depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM cours WHERE id_user = ?");
$stmt->execute([$id_user]); // Paramètre lié directement à l'execute
$coursData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare('select * from categories');
$stmt1->execute();
$categories = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les tags depuis la base de données
$query = "SELECT id_tags, name_tags FROM tags";
$stmt = $pdo->query($query);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
         #modal, #modal2 {
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
            background-color: #dadfdc;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80vh; /* Limiter la hauteur du modal */
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
            top: 40px; /* Place le menu juste en dessous de l'icône */
            right: 40px;
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
            <i class="fa-duotone fa-solid fa-gear gear-icon" style="color:#1c4933;font-size:25px;" onclick="toggleMenu()"></i>
            <div class="menu" id="menu">
                <a onclick="ajouterCour()" class="text-center" style="color:#1c4933">Ajouter cours</a>
                <a onclick="associerTag()" class="text-center" style="color:#1c4933">Associer tag</a>
                <a href="deconnexion.php" class="text-center hover:text-gray-400" style="color:#1c4933">log out</a>
            </div>
        </div>
    </nav>

    <!-- Contenu des cours -->
    <div class="container px-4">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold mb-4" style="color:#1c4933">Mes cours</h2>
            <div class="flex justify-center gap-5 my-4">
                <a href="statisticsProf.php" style="color: #dadfdc ;background-color:#1c4933;" class="text-white font-bold py-2 px-3 rounded hover:bg-red-600">Statistiques</a>
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
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="color:#1c4933"><?php echo htmlspecialchars($course['titre_cours']); ?></h5>
                            </a>
                            <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo htmlspecialchars($course['desc_cours']); ?></p>
                            <form method="POST" action="modifier_cours.php?id_cour=<?php echo $course['id_cours']; ?>" class="inline ml-2">
                                <input type="hidden" name="cours_id" value="<?php echo $course['id_cours']; ?>" />
                                <button type="submit" name="modifier" style="color: #1c4933 ;background-color:#dadfdc;" class="text-white py-2 px-3 rounded hover:bg-yellow-600"><i class="fa-solid fa-pen-to-square"></i></button>
                            </form>
                            <form method="POST" action="../controller/supprimer_cours.php" class="inline ml-2">
                                <input type="hidden" name="cours_id" value="<?php echo $course['id_cours']; ?>" />
                                <button type="submit" name="supprimer" style="color: #1c4933 ;background-color:#dadfdc;" class="text-white py-2 px-3 rounded hover:bg-red-600"><i class="fa-solid fa-trash"></i></button>
                            </form>
                            <form class="inline ml-1">
                               <a href="detailCours.php?id_cour=<?php echo $course['id_cours']; ?>" style="color: #1c4933 ;background-color:#dadfdc;"  class="text-white font-bold p-2 px-2 rounded hover:bg-red-600 w-24 h-24">Voir détail</a>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Modal pour ajouter un cours -->
        <div class="hidden fixed inset-0 flex justify-center items-center  bg-opacity-50 z-50 mt-12" id="modal">
           <div class="bg-white rounded-lg p-8 shadow-lg modal-content" style="width:80%;background-color:#dadfdc;border:2px solid #1c4933; box-shadow: 0 4px 12px rgba(127, 143, 125, 0.62);" >
             <h1 class="text-2xl font-bold text-center mb-4 " style="color:#1c4933;">Ajouter un cours</h1>
             <form id="courseForm" action="../controller/courController.php" method="POST" enctype="multipart/form-data">
                 <div class="mb-4">
                     <label for="title" class="block text-sm font-bold text-gray-700">Titre :</label>
                     <input type="text" id="title" name="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-800" required>
                 </div>
         
                 <div class="mb-4">
                     <label for="image_cours" class="block text-sm font-bold text-gray-700">Image (optionnelle) :</label>
                     <input type="text" name="image_cours" id="image_cours" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800">
                 </div>
         
                 <div class="mb-4">
                     <label for="description" class="block text-sm font-bold text-gray-700">Description :</label>
                     <textarea id="description" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-800" required></textarea>
                 </div>
                 <div class="mb-4">
                      <label for="id_categorie" class="block text-gray-700 font-bold">Sélectionner une catégorie:</label>
                      <select name="id_categorie" class="w-80 px-4 py-2 border border-gray-300 w-full rounded mt-1 focus:outline-none focus:ring-2 focus:ring-green-800">
                         <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id_categorie']; ?>"><?php echo $categorie['name_categorie']; ?></option>
                         <?php endforeach; ?>
                      </select>
                </div>
                 <div class="mb-4">
                     <label for="content" class="block text-sm font-bold text-gray-700">Contenu :</label>
                     <div class="flex space-x-4 mt-2">
                         <button type="button" id="markdownButton" class="px-4 py-2 w-full text-white rounded-md hover:bg-indigo-700 focus:outline-none" style="background-color:#1c4933;">Saisir du Markdown</button>
                         <button type="button" id="videoButton" class="px-4 py-2 w-full text-white rounded-md hover:bg-green-700 focus:outline-none" style="background-color:#1c4933;">Importer une vidéo</button>
                     </div>
                 </div>
                 <div id="markdownContainer" class="hidden mb-4">
                     <textarea id="markdownContent" name="markdownContent" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                 </div>
         
                 <div id="videoContainer" class="hidden mb-4">
                     <input type="file" id="videoFile" name="videoFile" accept="video/*" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                 </div>
         
                 <div class="flex justify-center  mt-4">
                     <button type="submit" class="px-6 w-full font-bold py-2 bg-blue-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" style="background-color:#1c4933;">Ajouter le cours</button>
            </div>
           </form>
         </div>
        </div>

        <!-- Modal pour associer des tag à un cours -->
        <div class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50 mt-10" id="modal2">
          <div class="bg-white rounded-lg p-8 w-96 shadow-lg modal-content" style="width:80%;background-color:#dadfdc;border:2px solid #1c4933; box-shadow: 0 4px 12px rgba(127, 143, 125, 0.62);">
            <h1 class="text-2xl font-bold text-center mb-4" style="color:#1c4933;">Associer des tags</h1>
            <form id="courseForm" action="../controller/associerTagCours.php" method="POST" enctype="multipart/form-data">
              
              <!-- Section Catégorie avec scroll -->
              <div class="mb-4">
                <label for="id_categorie" class="block text-gray-700 font-bold">Sélectionner une catégorie:</label>
                <div class="max-h-24 overflow-y-auto border border-gray-300 rounded mt-1">
                  <select name="id_categorie" class="w-full px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($coursData as $course): ?>
                      <option value="<?php echo $course['id_cours']; ?>"><?php echo $course['titre_cours']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              
              <!-- Section Tags avec scroll -->
              <div class="mb-4">
                <label class="block text-gray-700 font-bold">Tags :</label>
                <div class="space-y-2 mt-2 max-h-48 overflow-y-auto p-2 border border-gray-300 rounded">
                  <?php foreach ($tags as $tag): ?>
                    <div>
                      <input type="checkbox" id="tag_<?php echo $tag['id_tags']; ?>" name="tags[]" value="<?php echo $tag['id_tags']; ?>" class="mr-2">
                      <label for="tag_<?php echo $tag['id_tags']; ?>" class="text-sm text-gray-700"><?php echo $tag['name_tags']; ?></label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="flex justify-center mt-4">
                <button type="submit" class="px-6 w-full py-2 font-bold text-white rounded-md hover:bg-blue-700 focus:outline-none" style="background-color:#1c4933;">Associer des tags</button>
              </div>
            </form>
          </div>
        </div>
    </div>

    <script>
        const modalProjet = document.getElementById('modal');
        const modalTag = document.getElementById('modal2');

        function ajouterCour() {
            modalProjet.style.display = modalProjet.style.display === "flex" ? "none" : "flex"; // Toggle visibility
        }

        function associerTag() {
            modalTag.style.display = modalTag.style.display === "flex" ? "none" : "flex"; // Toggle visibility
        }

        // Fermer le modal en cliquant en dehors du contenu
        window.addEventListener('click', function(event) {
            if (event.target === modalProjet) {
                modalProjet.style.display = "none";
            }
        });

         // Fermer le modal en cliquant en dehors du contenu
         window.addEventListener('click', function(event) {
            if (event.target === modalTag) {
                modalTag.style.display = "none";
            }
        });

        // Fonction pour afficher/cacher le menu
        function toggleMenu() {
            const menu = document.getElementById("menu");
            if (menu.style.display === "none") {
                menu.style.display = "block"; // Si le menu est visible, on le cache
            } else {
                menu.style.display = "none"; // Sinon on l'affiche
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        const markdownButton = document.getElementById('markdownButton');
        const videoButton = document.getElementById('videoButton');
        const markdownContainer = document.getElementById('markdownContainer');
        const videoContainer = document.getElementById('videoContainer');

        // Initialiser SimpleMDE pour l'éditeur Markdown
        const simplemde = new SimpleMDE({ element: document.getElementById("markdownContent") });

        // Afficher la section Markdown et masquer la vidéo
        markdownButton.addEventListener('click', () => {
            markdownContainer.classList.remove('hidden');
            videoContainer.classList.add('hidden');
        });

        // Afficher la section Vidéo et masquer Markdown
        videoButton.addEventListener('click', () => {
            videoContainer.classList.remove('hidden');
            markdownContainer.classList.add('hidden');
        });

        // Empêcher l'envoi du formulaire si ni markdown ni vidéo n'est sélectionné
        document.getElementById("courseForm").addEventListener("submit", function(event) {
            // Si aucun contenu n'est sélectionné, avertir l'utilisateur
            if (!markdownContainer.classList.contains('hidden') && !document.getElementById('markdownContent').value) {
                alert("Veuillez entrer du contenu Markdown ou importer une vidéo.");
                event.preventDefault(); // Empêcher l'envoi du formulaire
            }
            if (!videoContainer.classList.contains('hidden') && !document.getElementById('videoFile').files.length) {
                alert("Veuillez importer une vidéo.");
                event.preventDefault(); // Empêcher l'envoi du formulaire
            }
        });
    </script>
</body>
</html>
