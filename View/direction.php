<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>direction</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/gsap.min.js"></script> <!-- Ajoutez GSAP ici -->
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dadfdc;
            overflow-x: hidden;
        }
        i {
            font-size: 20px;
        }

        .choix {
            height: 250px;
            width: 250px;
            padding: 10px;
            border-radius: 100px;
            background-color: #833a62;
            text-align: center;
            border-top: 1px solid #dadfdc;
            border-left: 1px solid #dadfdc;
            box-shadow: 12px 12px 12px rgba(106, 134, 109, 0.54); /* Ombre */
            transition: transform 0.3s ease; /* Transition pour l'animation */
            opacity: 0; /* Initialement caché */
            transform: scale(0.8); /* Commence plus petit */
        }
        .choix i {
            margin-top: 30px;
            font-size: 200px;
        }
        .choix div {
            margin-top: 10px;
            font-size: 20px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <?php 
    include_once 'header.php';
    ?>

    <main class="py-24 bg-gradient-to-r to-indigo-600" style="color:#833a62;">
        <div class="flex justify-center gap-20 mx-64 py-24">
            <!-- Choix Etudiant -->
            <div class="choix">
            <h2 class="text-black">etudiant</h2>
                  
                    <div><a href="register.php?role=etudiant" class="font-bold">Étudiant</a></div>
                </a>
            </div>
            <!-- Choix Enseignant -->
            <div class="choix">
                <a href="register.php?role=enseignant">
                    <h2 class="text-black">Enseignant</h2>
                     <!-- alt="Enseignant"> -->
                    <div><a href="register.php?role=enseignant" class="font-bold">Enseignant</a></div>
                </a>
            </div>
        </div>
    </main>

    <script>
        // Animation GSAP pour faire apparaître les éléments .choix
        gsap.to(".choix", {
            opacity: 1,
            scale: 1,
            duration: 1.5,
            stagger: 0.2, // Pour espacer l'animation de chaque élément
            ease: "power4.out" // Easing pour rendre l'animation plus fluide
        });

        // Effet de survol pour augmenter la taille des choix
        document.querySelectorAll(".choix").forEach(item => {
            item.addEventListener("mouseenter", () => {
                gsap.to(item, { scale: 1.1, duration: 0.3 });
            });
            item.addEventListener("mouseleave", () => {
                gsap.to(item, { scale: 1, duration: 0.3 });
            });
        });
    </script>

</body>
</html>
