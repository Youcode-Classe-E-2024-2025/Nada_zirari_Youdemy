CREATE DATABASE coursbase;

use coursbase;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('Etudiant', 'Enseignant', 'Admin') NOT NULL,
    is_valid TINYINT(1) NOT NULL DEFAULT 0
);

ALTER TABLE user
ADD COLUMN status ENUM('activer', 'désactiver') NOT NULL DEFAULT 'désactiver';

UPDATE user
SET user_role = 'Admin'
WHERE id_user = 25;
UPDATE user
SET user_role = 'Enseignant'
WHERE id_user = 5;

UPDATE user
SET user_role = 'Etudiant'
WHERE id_user = 3;
-- Table des cours
CREATE TABLE cours (
    id_cours INT PRIMARY KEY AUTO_INCREMENT,
    titre_cours VARCHAR(255) NOT NULL,
    image_cours VARCHAR(255) NULL,
    desc_cours VARCHAR(255) NOT NULL,
    content_type ENUM('markdown', 'video') NOT NULL,
    content_cours TEXT NOT NULL,
    id_user INT, -- Référence à l'utilisateur (professeur)
    id_categorie INT, -- Référence à la catégorie du cours
    FOREIGN KEY (id_user) REFERENCES user(id_user), -- Lien avec la table des utilisateurs
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie) -- Lien avec la table des catégories
);
 -- Categories Table
    CREATE TABLE categories (
        id_categorie INT PRIMARY KEY AUTO_INCREMENT,
        name_categorie VARCHAR(100) NOT NULL UNIQUE
    );

  CREATE TABLE tags (
        id_tags INT  PRIMARY KEY AUTO_INCREMENT,
        name_tags VARCHAR(100) NOT NULL UNIQUE
    );
-- Insertion d'une catégorie

-- Table many-to-many entre les cours et les tags
CREATE TABLE cours_tags (
    id_cours INT,          -- Référence à un cours
    id_tags INT,           -- Référence à un tag
    PRIMARY KEY (id_cours, id_tags),  -- La combinaison de (id_cours, id_tags) doit être unique
    FOREIGN KEY (id_cours) REFERENCES cours(id_cours) ON DELETE CASCADE, -- Lien avec la table des cours
    FOREIGN KEY (id_tags) REFERENCES tags(id_tags) ON DELETE CASCADE    -- Lien avec la table des tags
);

-- Table d'inscription entre les étudiants et les cours
CREATE TABLE inscription (
    id_user INT,          -- Référence à l'utilisateur (étudiant)
    id_cours INT,         -- Référence au cours
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Date d'inscription
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,   -- Lien avec la table des utilisateurs
    FOREIGN KEY (id_cours) REFERENCES cours(id_cours) ON DELETE CASCADE  -- Lien avec la table des cours
);


