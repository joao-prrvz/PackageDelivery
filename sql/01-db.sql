DROP DATABASE IF EXISTS `package_delivery`;

CREATE DATABASE `package_delivery`;

USE `package_delivery`;

CREATE TABLE `Employe`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `nom` VARCHAR(500) NOT NULL,
    `prenom` VARCHAR(500) NOT NULL,
    `email` VARCHAR(300) NOT NULL,
    `motDePasse` VARCHAR(500) NOT NULL,
    `estLivreur` BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE `RouteLivraison`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `dateRoute` DATE NOT NULL,
    `createurId` INT UNSIGNED NOT NULL,
	CONSTRAINT fk_routelivraison_createur
        FOREIGN KEY (`createurId`) REFERENCES `Employe`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE `Paquet`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `numeroPostal` VARCHAR(500) NOT NULL,
    `nomDestinataire` VARCHAR(500) NOT NULL,
    `prenomDestinataire` VARCHAR(300) NOT NULL,
    `adresseDestinataire` VARCHAR(300) NOT NULL,
    `latitudeAdresse` FLOAT NOT NULL,
    `longitudeAdresse` FLOAT NOT NULL,
    `statutLivraison` ENUM('Not delivered', 'Delivering', 'Delivered') NOT NULL DEFAULT 'Not delivered',
    `createurId` INT UNSIGNED NOT NULL,
    `dateLivraison` DATE NOT NULL,
    `livreurId` INT UNSIGNED NOT NULL,
    `ordreRouteLivraison` INT UNSIGNED DEFAULT NULL,
    `routeLivraisonId` INT UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_paquet_createur
        FOREIGN KEY (`createurId`) REFERENCES `Employe`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT,
	CONSTRAINT fk_paquet_livreur
        FOREIGN KEY (`livreurId`) REFERENCES `Employe`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT,
	CONSTRAINT fk_paquet_routelivraison
        FOREIGN KEY (`routeLivraisonId`) REFERENCES `RouteLivraison`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT
);
