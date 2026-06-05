DROP DATABASE IF EXISTS `package_delivery`;

CREATE DATABASE `package_delivery`;

USE `package_delivery`;

CREATE TABLE `Employee`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `lastName` VARCHAR(500) NOT NULL,
    `firstName` VARCHAR(500) NOT NULL,
    `email` VARCHAR(300) NOT NULL,
    `password` VARCHAR(500) NOT NULL,
    `isDeliveryPerson` BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE `DeliveryRoute`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `dateDelivery` DATE NOT NULL,
    `creatorId` INT UNSIGNED NOT NULL,
	CONSTRAINT fk_deliveryroute_creator
        FOREIGN KEY (`creatorId`) REFERENCES `Employee`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE `Package`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `postalNumber` VARCHAR(500) NOT NULL,
    `recipientFirstName` VARCHAR(500) NOT NULL,
    `recipientLastName` VARCHAR(300) NOT NULL,
    `recipientAddress` VARCHAR(300) NOT NULL,
    `addressLatitude` FLOAT NOT NULL,
    `addressLongitude` FLOAT NOT NULL,
    `status` ENUM('Not delivered', 'Delivering', 'Delivered') NOT NULL DEFAULT 'Not delivered',
    `creatorId` INT UNSIGNED NOT NULL,
    `deliveryDate` DATE NOT NULL,
    `deliveryPersonId` INT UNSIGNED NOT NULL,
    `routeIndex` INT UNSIGNED DEFAULT NULL,
    `deliveryRouteId` INT UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_package_creator
        FOREIGN KEY (`creatorId`) REFERENCES `Employee`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT,
	CONSTRAINT fk_package_deliveryperson
        FOREIGN KEY (`deliveryPersonId`) REFERENCES `Employee`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT,
	CONSTRAINT fk_package_deliveryroute
        FOREIGN KEY (`deliveryRouteId`) REFERENCES `DeliveryRoute`(id)
        ON DELETE CASCADE ON UPDATE RESTRICT
);
