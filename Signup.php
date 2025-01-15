<?php
// Inclure la configuration de la base de données
include_once 'config.php';

// Initialiser les variables pour les erreurs
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validation des champs
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Hash du mot de passe pour la sécurité
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données
        $database = Database::getInstance();
        $conn = $database->getConnection();

        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Insertion de l'utilisateur dans la base de données
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                header("Location: login.php"); // Rediriger vers la page de connexion après inscription réussie
                exit();
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-900 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-blue-500 mb-6">Inscription</h2>
        
        <?php if (!empty($error)) : ?>
            <div class="text-red-500 text-sm mb-4"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="signup.php">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-600">Nom :</label>
                <input type="text" id="name" name="name" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email :</label>
                <input type="email" id="email" name="email" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe :</label>
                <input type="password" id="password" name="password" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-blue-600">Rôle :</label>
                <select id="role" name="role" class="mt-2 p-2 w-full border border-gray-300 rounded-md" required>
                    <option value="student">Étudiant</option>
                    <option value="teacher">Enseignant</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-green-500 transition duration-200">S'inscrire</button>
        </form>

        <p class="mt-4 text-sm text-gray-600">Vous avez déjà un compte ? <a href="login.php" class="text-green-500 hover:text-green-700">Se connecter</a></p>
    </div>

</body>
</html>
