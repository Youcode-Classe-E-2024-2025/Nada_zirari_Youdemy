

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-900 flex justify-center items-center h-screen">

    <!-- Formulaire de connexion -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-black mb-6">Bienvenue sur Youdemy</h2>
        <form id="loginForm" action="../controller/loginController.php" method="POST" onsubmit="return validateLoginForm()">
                    <div class="mb-4">
                        <label for="email" class="block text-black">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4930" placeholder="Email" required>
                        <span id="emailError" class="text-red-500 text-sm"><?= $errors['email'] ?? '' ?></span>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-black">Mot de passe:</label>
                        <input type="password" id="password" name="password" class="w-full p-3 mt-1 border border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-800" style="border-color:#1c4930" placeholder="Mot de passe" required>
                        <span id="passwordError" class="text-red-500 text-sm"><?= $errors['password'] ?? '' ?></span>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 bg-sky-700 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-green-800" style="background-color:#1c4933;">
                            Se connecter
                        </button>
                    </div>
                    <div class="flex justify-center text-center text-black gap-2 mt-4">  
                       <p>Vous n'avez pas de compte ?</p>
                       <a href="register.php"style="color:#1c4930;">S'inscrire</a>
                    </div>
                </form>
    </div>
    <script>
    function validateLoginForm() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let valid = true;

        // Réinitialiser les messages d'erreur
        document.getElementById('emailError').innerText = '';
        document.getElementById('passwordError').innerText = '';

        // Vérification de l'email
        if (email === '') {
            document.getElementById('emailError').innerText = "L'email est requis.";
            valid = false;
        }

        // Vérification du mot de passe
        if (password === '') {
            document.getElementById('passwordError').innerText = "Le mot de passe est requis.";
            valid = false;
        }

        return valid;
    }
</script>
</body>

</html>
