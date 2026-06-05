-- =============================================================
-- FAKE DATA — package_delivery
-- 1 admin + 5 drivers, bcrypt password for all
-- 5 packages per driver (assigned) + 10 unassigned packages
-- Real Geneva, Switzerland addresses with real coordinates
-- =============================================================

USE `package_delivery`;

INSERT INTO Employe (id, nom, prenom, email, motDePasse, estLivreur) VALUES
(1, 'Admin', 'System', 'admin@company.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', FALSE),

(2, 'Dupont', 'Marc', 'marc.dupont@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(3, 'Roche', 'Elise', 'elise.roche@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(4, 'Favre', 'Luc', 'luc.favre@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(5, 'Morel', 'Sophie', 'sophie.morel@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(6, 'Lambert', 'Julien', 'julien.lambert@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(7, 'Girard', 'Nina', 'nina.girard@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE),
(8, 'Bertrand', 'Hugo', 'hugo.bertrand@example.com', '$2a$12$dHBrZQ70cTZfxRdIlwywteKkHF9BnUefQaA1tyRo5KhCD/iH7IRom', TRUE);


INSERT INTO Paquet (
    numeroPostal, prenomDestinataire, nomDestinataire, adresseDestinataire,
    latitudeAdresse, longitudeAdresse, statutLivraison,
    createurId, dateLivraison, livreurId, routeLivraisonId
) VALUES
('1204', 'Alice', 'Martin', 'Rue du Rhône 40, Geneva', 46.2037, 6.1470, 'Not delivered', 1, CURDATE(), 2, NULL),
('1205', 'Bob', 'Durand', 'Rue de Carouge 85, Geneva', 46.1915, 6.1383, 'Delivering', 1, CURDATE(), 2, NULL),
('1201', 'Claire', 'Petit', 'Rue de Lausanne 67, Geneva', 46.2140, 6.1479, 'Delivered', 1, CURDATE(), 2, NULL),

('1206', 'David', 'Morel', 'Avenue de Champel 24, Geneva', 46.1929, 6.1532, 'Not delivered', 1, CURDATE(), 3, NULL),
('1205', 'Emma', 'Favre', 'Rue de l’École-de-Médecine 20, Geneva', 46.1978, 6.1437, 'Delivering', 1, CURDATE(), 3, NULL),

('1205', 'Felix', 'Lambert', 'Rue des Bains 23, Geneva', 46.2012, 6.1389, 'Delivered', 1, CURDATE(), 4, NULL),
('1205', 'Gina', 'Roche', 'Boulevard Georges-Favon 20, Geneva', 46.2025, 6.1375, 'Not delivered', 1, CURDATE(), 4, NULL),

('1203', 'Hugo', 'Girard', 'Rue de la Servette 90, Geneva', 46.2163, 6.1288, 'Delivering', 1, CURDATE(), 5, NULL),
('1217', 'Iris', 'Bertrand', 'Rue de Meyrin 49, Geneva', 46.2231, 6.1104, 'Delivered', 1, CURDATE(), 5, NULL),

('1207', 'Jack', 'Dupont', 'Rue de la Terrassière 14, Geneva', 46.2018, 6.1590, 'Not delivered', 1, CURDATE(), 6, NULL);
