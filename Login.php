<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black flex justify-center items-center h-screen">

    <!-- Formulaire de connexion -->
    <div class="bg-blue-900 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-black mb-6">Bienvenue sur Youdemy</h2>
        <form action="login.php" method="POST" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-black">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-900 focus:outline-none" />
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-black">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-900 focus:outline-none" />
            </div>

            <!-- Erreur de connexion -->
            <?php if (isset($_GET['error'])): ?>
            <div class="text-red-500 text-sm">
                <p>Identifiants incorrects. Veuillez réessayer.</p>
            </div>
            <?php endif; ?>

            <!-- Bouton de connexion -->
            <div>
                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-blue-900">
                    Se connecter
                </button>
            </div>

            <!-- Lien d'inscription -->
            <div class="text-center mt-4">
                <p class="text-sm text-black">Pas encore de compte ? <a href="register.php"
                        class="text-red hover:text-green-600">Inscrivez-vous</a></p>
            </div>
        </form>
    </div>

</body>

</html>
