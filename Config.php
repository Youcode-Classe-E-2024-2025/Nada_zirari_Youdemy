<?php
// Constantes pour la configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'youdemy2'); // Nom de la base de données Youdemy
define('DB_USER', 'root');    // Utilisateur de la base de données
define('DB_PASS', '');        // Mot de passe de la base de données (si nécessaire)

class Database {
    private static $instance = null;
    private $connection;

    // Le constructeur est privé pour éviter la création d'instances multiples
    private function __construct() {
        try {
            // Connexion à la base de données avec PDO
            $this->connection = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
                DB_USER, DB_PASS
            );
            // Configuration de l'attribut pour la gestion des erreurs
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si une erreur survient, on l'affiche
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir l'instance de la classe Database (patron Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Méthode pour récupérer la connexion PDO
    public function getConnection() {
        return $this->connection;
    }
}
?>
