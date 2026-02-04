CREATE DATABASE IF NOT EXISTS mini_projet_taches;
USE mini_projet_taches;

CREATE TABLE taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    priorite ENUM('basse','moyenne','haute') DEFAULT 'moyenne',
    statut ENUM('a_faire','en_cours','terminee') DEFAULT 'a_faire',
    date_creation DATE,
    date_limite DATE,
    responsable VARCHAR(100)
);
