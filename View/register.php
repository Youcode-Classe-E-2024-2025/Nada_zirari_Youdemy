
<?php
// Récupérer le rôle choisi dans l'URL
$role = isset($_GET['role']) ? $_GET['role'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/register.js"></script>
</head>
<body class="bg-pink-800 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-pink-800 mb-6">Inscription</h2>
        
        <?php if (!empty($error)) : ?>
            <div class="text-red-500 text-sm mb-4"><?php echo $error; ?></div>
        <?php endif; ?>

        <form id="registerForm" action="../controller/registerController.php" method="POST" onsubmit="return validateForm()">
                    <!-- Ajout du rôle caché -->
                   <input type="hidden" name="role" value="<?= $role ?>"> 
                    <!-- Récupération des informations utilisateur -->
                    <div class="mb-2">
                        <label for="username" class="block text-black">Nom d'utilisateur :</label>
                        <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" 
                               class="w-full p-3 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" 
                               placeholder="Nom d'utilisateur" style="border-color:#1c4930">
                        <span id="usernameError" class="text-red-500 text-sm"><?= $errors['username'] ?? '' ?></span>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="block text-black">Email :</label>
                        <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" 
                               class="w-full p-3 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" 
                               placeholder="Email" style="border-color:#1c4930">
                        <span id="emailError" class="text-red-500 text-sm"><?= $errors['email'] ?? '' ?></span>
                    </div>
                    
                    <div class="mb-2">
                        <label for="password" class="block text-black">Mot de passe :</label>
                        <input type="password" id="password" name="password" 
                               class="w-full p-3 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" 
                               placeholder="Mot de passe" style="border-color:#1c4930">
                        <span id="passwordError" class="text-red-500 text-sm"><?= $errors['password'] ?? '' ?></span>
                    </div>
                   
                    <div class="mb-2">
                        <label for="confirmPassword" class="block text-black">Confirmer le mot de passe :</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" 
                               class="w-full p-3 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" 
                               placeholder="Confirmer le mot de passe" style="border-color:#1c4930">
                        <span id="confirmPasswordError" class="text-red-500 text-sm"><?= $errors['confirmPassword'] ?? '' ?></span>
                    </div>
                    <!-- Bouton d'inscription -->
                    <div class="mt-4">
                        <button type="submit" class="w-full py-3 bg-sky-700 text-white font-bold rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-green-800" style="background-color:#833a62;">
                            S'inscrire
                        </button>
                    </div>

                    <!-- Lien vers la page de connexion -->
                    <div class="flex justify-center text-center text-black gap-2 mt-4">  
                       <p>Vous avez déjà un compte ?</p>
                       <a href="login.php" class="font-bold" style="color:#1c4930;">Se connecter</a>
                    </div>
                </form>

    </div>

</body>
</html>
