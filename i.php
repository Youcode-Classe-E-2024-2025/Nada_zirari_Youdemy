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
  <header class="bg-white shadow">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="text-3xl ml-60 font-bold text-blue-600">Youdemy</a>
      <!-- <nav class="space-x-6">
        <a href="#" class="text-gray-700 hover:text-blue-600">Courses</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">About Us</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">Contact</a>
        <a href="#" class="text-blue-600 font-semibold">Sign In</a>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Sign Up</a>
      </nav> -->
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-cover bg-center h-screen" style="background-image: url('https://via.placeholder.com/1920x1080');">
    <div class="bg-black bg-opacity-50 h-full flex items-center justify-center text-center">
      <div class="text-white px-6">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Learn Anytime, Anywhere</h1>
        <p class="text-lg md:text-2xl mb-6">Join Youdemy and unlock your potential with thousands of online courses.</p>
        <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Visit US</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-8">Why Choose Youdemy?</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-6 shadow rounded">
          <img src="https://via.placeholder.com/100" alt="Feature 1" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Personalized Learning</h3>
          <p class="text-gray-600">Tailored courses to suit your learning style.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="https://via.placeholder.com/100" alt="Feature 2" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Expert Instructors</h3>
          <p class="text-gray-600">Learn from industry leaders and professionals.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="https://via.placeholder.com/100" alt="Feature 3" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Interactive Quizzes</h3>
          <p class="text-gray-600">Engaging activities to test your knowledge.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="https://via.placeholder.com/100" alt="Feature 4" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Certifications</h3>
          <p class="text-gray-600">Earn certificates to showcase your skills.</p>
        </div>
      </div>
    </div>
  </section>
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
<!-- hhhhhhhhhhhhhhhhhhhh -->
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
