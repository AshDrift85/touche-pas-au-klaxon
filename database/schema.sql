-- Touche pas au klaxon : script de création de la base de données
-- Compatible MySQL 8 / MariaDB 10.4+

DROP DATABASE IF EXISTS touche_pas_au_klaxon;
CREATE DATABASE touche_pas_au_klaxon
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE touche_pas_au_klaxon;

CREATE TABLE agency (
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_agency_name (name)
) ENGINE=InnoDB;

CREATE TABLE user (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    last_name  VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    phone      VARCHAR(20)  NOT NULL,
    email      VARCHAR(255) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_email (email)
) ENGINE=InnoDB;

CREATE TABLE trip (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    departure_agency_id INT UNSIGNED NOT NULL,
    arrival_agency_id   INT UNSIGNED NOT NULL,
    departure_at        DATETIME NOT NULL,
    arrival_at          DATETIME NOT NULL,
    total_seats         TINYINT UNSIGNED NOT NULL,
    available_seats     TINYINT UNSIGNED NOT NULL,
    author_id           INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_trip_departure FOREIGN KEY (departure_agency_id) REFERENCES agency (id),
    CONSTRAINT fk_trip_arrival   FOREIGN KEY (arrival_agency_id)   REFERENCES agency (id),
    CONSTRAINT fk_trip_author    FOREIGN KEY (author_id)           REFERENCES user (id) ON DELETE CASCADE,
    CONSTRAINT ck_trip_agencies  CHECK (departure_agency_id <> arrival_agency_id),
    CONSTRAINT ck_trip_dates     CHECK (arrival_at > departure_at),
    CONSTRAINT ck_trip_seats     CHECK (available_seats <= total_seats AND total_seats > 0)
) ENGINE=InnoDB;
