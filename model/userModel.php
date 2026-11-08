<?php

require_once __DIR__ . '/database.php';

/**
 * Cherche un utilisateur par son adresse email.
 *
 * @param string $email L'adresse email
 * @return array|false L'utilisateur, ou false s'il n'existe pas
 */
function getUserByEmail($email)
{
    $pdo = getPdo();

    $query = $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $query->execute(['email' => $email]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Renvoie tous les utilisateurs, triés par nom puis prénom.
 *
 * @return array La liste des utilisateurs
 */
function getUsers()
{
    $pdo = getPdo();

    $query = $pdo->query('SELECT * FROM user ORDER BY last_name, first_name');

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
