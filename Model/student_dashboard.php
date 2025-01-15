<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord - Étudiant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Wrapper -->
  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-600 text-white flex flex-col">
      <div class="py-4 px-6 text-center border-b border-blue-500">
        <h1 class="text-2xl font-bold">Youdemy</h1>
      </div>
      <nav class="flex-1 px-4 py-6">
        <ul class="space-y-4">
          <li>
            <a href="#" class="block px-4 py-2 rounded hover:bg-blue-500">Accueil</a>
          </li>
          <li>
            <a href="#" class="block px-4 py-2 rounded hover:bg-blue-500">Mes cours</a>
          </li>
          <li>
            <a href="#" class="block px-4 py-2 rounded hover:bg-blue-500">Profil</a>
          </li>
          <li>
            <a href="../logout.php" class="block px-4 py-2 bg-red-500 rounded hover:bg-green-500">Déconnexion</a>
          
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 p-6">
      <!-- Header -->
      <header class="flex justify-between items-center bg-white shadow p-4 rounded">
        <h2 class="text-xl font-semibold">Bienvenue, Étudiant</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Rechercher un cours</button>
      </header>

      <!-- Mes Cours Section -->
      <section class="mt-6">
        <h3 class="text-2xl font-semibold mb-4">Mes cours</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Carte de cours -->
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="https://via.placeholder.com/300x200" alt="Cours" class="w-full h-48 object-cover">
            <div class="p-4">
              <h4 class="text-lg font-bold">Titre du cours</h4>
              <p class="text-gray-600 text-sm mb-4">Description courte du cours...</p>
              <a href="#" class="text-blue-600 hover:underline">Continuer</a>
            </div>
          </div>
          <!-- Répétez les cartes pour d'autres cours -->
        </div>
      </section>
    </main>

  </div>

</body>
</html>
