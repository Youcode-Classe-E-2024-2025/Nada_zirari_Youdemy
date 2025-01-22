<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color:white;
            overflow-x: hidden;
        }

        canvas {
            display: block;
            height:500px;
            width: 100%;
            background-color: #dadfdc;    
        }
    </style>
</head>
<header class="fixed top-0 left-0 w-full bg-transparent py-1 px-6 bg-white">
        <div class="flex items-center justify-between">
            <img src="assets/images/logo.png" alt="Logo" class="w-20 m-2">
            <nav class="space-x-8 md:flex">
                <a href="home.php" class="text-black font-bold hover:text-pink-500">Home</a>
                <!-- <a href="AboutUs.php" class="text-black font-bold hover:text-pink-500">About us</a> -->
                <a href="Cours.php" class="text-black font-bold hover:text-pink-500">Cours</a>
            </nav>
            <div class="space-x-4">
                <a href="direction.php" style="background-color:#833a62" class="text-white px-4 py-2 border border-white font-bold rounded-md hover:bg-green-500">Sign Up !</a>
                <a href="login.php" style="background-color:#833a62" class="text-white px-4 py-2 border border-white font-bold rounded-md hover:bg-green-500">Log In</a>
            </div>
        </div>
</header>
<body>

    <!-- Header -->
  
<body class="bg-gray-50">
  <!-- Header -->
  
  <!-- Hero Section -->
  <section class="bg-cover bg-center h-screen" style="background-image: url('assets/images/logo.png');">
    <div class="bg-black bg-opacity-50 h-full flex items-center justify-center text-center">
      <div class="text-white px-6">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Learn Anytime, Anywhere</h1>
        <p class="text-lg md:text-2xl mb-6">Join Youdemy and unlock your potential with thousands of online courses.</p>
        
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-8">Why Choose Youdemy?</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-6 shadow rounded">
          <img src="assets/images/home.jpg" alt="Feature 1" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Personalized Learning</h3>
          <p class="text-gray-600">Tailored courses to suit your learning style.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="assets/images/home.jpg" alt="Feature 2" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Expert Instructors</h3>
          <p class="text-gray-600">Learn from industry leaders and professionals.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="assets/images/home.jpg" alt="Feature 3" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Interactive Quizzes</h3>
          <p class="text-gray-600">Engaging activities to test your knowledge.</p>
        </div>
        <div class="bg-white p-6 shadow rounded">
          <img src="assets/images/home.jpg" alt="Feature 4" class="mx-auto mb-4">
          <h3 class="text-xl font-semibold">Certifications</h3>
          <p class="text-gray-600">Earn certificates to showcase your skills.</p>
        </div>
      </div>
    </div>
  </section>

 
    
    

    <!-- Footer -->
    <footer class="py-8" style="background-color:#833a62">
        <div class="max-w-screen-xl text-center text-white">
            <p>&copy; 2025 Votre entreprise. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="../assets/home.js"></script>
</body>
</html>
