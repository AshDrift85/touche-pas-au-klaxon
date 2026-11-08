<?php

/**
 * Ouvre la connexion à la base de données avec les réglages du fichier .env.
 *
 * @return PDO La connexion à MySQL
 */
function getPdo()
{
    // Lit le fichier .env (une ligne = un réglage)
    $env = parse_ini_file(__DIR__ . '/../.env');

    return new PDO(
        'mysql:host=' . $env['DB_HOST'] . ';dbname=' . $env['DB_NAME'] . ';charset=utf8mb4',
        $env['DB_USER'],
        $env['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}
