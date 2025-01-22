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

<body>

    <!-- Header -->
   <?php 
   include_once 'header.php';
   ?>
<body class="bg-gray-50">
  <!-- Header -->
  
  <!-- Hero Section -->
  <section class="bg-cover bg-center h-screen" style="background-image: url('../assets/images/logo.png');">
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
    <footer class="py-8" style="background-color:#833a62">
        <div class="max-w-screen-xl text-center text-white">
            <p>&copy; 2025 Votre entreprise. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="../assets/home.js"></script>
</body>
</html>
