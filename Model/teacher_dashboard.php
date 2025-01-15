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
  <div class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-800 text-white shadow-md">
      <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <h1 class="text-2xl font-bold">Youdemy</h1>
        <nav class="flex space-x-4">
          <a href="#" class="hover:text-gray-300">Accueil</a>
          <a href="#" class="hover:text-gray-300">Mes cours</a>
          <a href="#" class="hover:text-gray-300">Statistiques</a>
          <a href="#" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Déconnexion</a>
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto flex-1 py-10 px-6">
      <!-- Welcome Section -->
      <section class="mb-8">
        <h2 class="text-3xl font-semibold text-gray-800">Bienvenue, Enseignant</h2>
        <p class="text-gray-600 mt-2">Gérez vos cours, ajoutez-en de nouveaux et consultez vos statistiques.</p>
      </section>

      <!-- Actions Section -->
      <section class="mb-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Ajouter un cours -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Ajouter un cours</h3>
          <p class="text-gray-600 mb-6">Créez un nouveau cours avec des détails complets pour vos étudiants.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</a>
        </div>

        <!-- Mes cours -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Mes cours</h3>
          <p class="text-gray-600 mb-6">Consultez et gérez les cours que vous avez créés.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Voir</a>
        </div>

        <!-- Statistiques -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Statistiques</h3>
          <p class="text-gray-600 mb-6">Analysez les performances de vos cours et l'engagement des étudiants.</p>
          <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Consulter</a>
        </div>
      </section>

      <!-- Liste des cours -->
      <section class="mb-10">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Mes cours</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Carte de cours -->
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="https://via.placeholder.com/300x200" alt="Cours" class="w-full h-48 object-cover">
            <div class="p-4">
              <h4 class="text-lg font-bold">Titre du cours</h4>
              <p class="text-gray-600 text-sm mb-4">Description courte du cours...</p>
              <div class="flex justify-between">
                <a href="#" class="text-blue-600 hover:underline">Modifier</a>
                <a href="#" class="text-red-600 hover:underline">Supprimer</a>
              </div>
            </div>
          </div>
          <!-- Répétez les cartes pour d'autres cours -->
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

</body>
</html>
