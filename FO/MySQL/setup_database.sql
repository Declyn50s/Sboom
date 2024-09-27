-- Créer la base de données SBOOM si elle n'existe pas déjà
CREATE DATABASE IF NOT EXISTS sboom CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Utiliser la base de données sboom
USE sboom;

-- Créer la table utilisateurs si elle n'existe pas déjà
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Clé primaire unique pour chaque utilisateur
    email VARCHAR(255) NOT NULL UNIQUE,     -- Adresse e-mail unique
    prenom VARCHAR(100) NOT NULL,           -- Prénom de l'utilisateur
    nom VARCHAR(100) NOT NULL,              -- Nom de famille de l'utilisateur
    date_naissance DATE NOT NULL,           -- Date de naissance de l'utilisateur (au format YYYY-MM-DD)
    telephone VARCHAR(20) NOT NULL,         -- Numéro de téléphone (avec indicatif)
    mot_de_passe VARCHAR(255) NOT NULL,     -- Mot de passe hashé
    adresse VARCHAR(255) NOT NULL,          -- Adresse de l'utilisateur
    code_postal VARCHAR(10) NOT NULL,       -- Code postal
    localite VARCHAR(100) NOT NULL,         -- Localité (région/ville)
    newsletter TINYINT(1) NOT NULL DEFAULT 0, -- Abonnement à la newsletter (0 = non abonné, 1 = abonné)
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Date et heure d'inscription
);

-- Message d'information sur le succès de la création
SELECT 'La base de données et la table utilisateurs ont été créées avec succès' AS Message;
