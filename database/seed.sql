-- Touche pas au klaxon : jeu d'essai
-- Mot de passe des comptes utilisateurs : User1234!
-- Mot de passe du compte admin : Admin1234!

USE touche_pas_au_klaxon;

INSERT INTO agency (name) VALUES
    ('Paris'),
    ('Lyon'),
    ('Marseille'),
    ('Toulouse'),
    ('Nice'),
    ('Nantes'),
    ('Strasbourg'),
    ('Montpellier'),
    ('Bordeaux'),
    ('Lille'),
    ('Rennes'),
    ('Reims');

INSERT INTO user (last_name, first_name, phone, email, password, role) VALUES
    ('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$MmKGnK0kgo/bfWAHx62YZOOsTffTDhZG/0AnzjnM1z.slSojgaCbq', 'user'),
    ('Admin', 'Admin', '0600000000', 'admin@email.fr', '$2y$10$qKdcmRvbV9qLtsjJNDtxAeycFVWfDVgJX7187x.nQhVSMAQptjED.', 'admin');

INSERT INTO trip (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, author_id) VALUES
    (1, 2, '2026-11-12 07:30:00', '2026-11-12 11:45:00', 4, 3, 1),
    (2, 3, '2026-11-12 14:00:00', '2026-11-12 17:30:00', 3, 2, 2),
    (3, 5, '2026-11-13 08:00:00', '2026-11-13 10:30:00', 4, 1, 3),
    (9, 4, '2026-11-14 09:15:00', '2026-11-14 11:45:00', 3, 3, 4),
    (10, 1, '2026-11-17 06:45:00', '2026-11-17 09:30:00', 4, 2, 5),
    (6, 11, '2026-11-18 13:00:00', '2026-11-18 14:30:00', 3, 2, 6),
    (7, 12, '2026-11-19 08:30:00', '2026-11-19 12:00:00', 4, 4, 7),
    (8, 3, '2026-11-20 16:00:00', '2026-11-20 17:45:00', 3, 1, 8),
    (1, 10, '2026-11-24 07:00:00', '2026-11-24 09:45:00', 4, 3, 9),
    (4, 9, '2026-11-25 10:00:00', '2026-11-25 12:30:00', 3, 2, 10),
    (2, 7, '2026-11-26 07:45:00', '2026-11-26 12:15:00', 4, 2, 1),
    (12, 1, '2026-12-01 08:00:00', '2026-12-01 09:45:00', 3, 3, 11),
    (5, 8, '2026-12-02 09:30:00', '2026-12-02 13:15:00', 4, 1, 12),
    (11, 6, '2026-12-03 15:00:00', '2026-12-03 16:30:00', 3, 2, 13),
    (3, 2, '2026-12-04 17:00:00', '2026-12-04 20:30:00', 4, 3, 14),
    (1, 9, '2026-11-16 08:00:00', '2026-11-16 13:00:00', 3, 0, 15),
    (1, 2, '2026-10-20 07:30:00', '2026-10-20 11:45:00', 4, 2, 16),
    (9, 4, '2026-10-28 09:00:00', '2026-10-28 11:30:00', 3, 1, 17);
