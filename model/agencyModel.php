<?php

require_once __DIR__ . '/database.php';

/**
 * Renvoie toutes les agences, triées par nom.
 *
 * @return array La liste des agences
 */
function getAgencies()
{
    $pdo = getPdo();

    $query = $pdo->query('SELECT id, name FROM agency ORDER BY name');

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Crée une agence.
 *
 * @param string $name Le nom de l'agence
 * @return int L'id de la nouvelle agence
 */
function createAgency($name)
{
    $pdo = getPdo();

    $query = $pdo->prepare('INSERT INTO agency (name) VALUES (:name)');
    $query->execute(['name' => $name]);

    return (int) $pdo->lastInsertId();
}

/**
 * Change le nom d'une agence.
 *
 * @param int $id L'id de l'agence
 * @param string $name Le nouveau nom
 * @return void
 */
function renameAgency($id, $name)
{
    $pdo = getPdo();

    $query = $pdo->prepare('UPDATE agency SET name = :name WHERE id = :id');
    $query->execute(['name' => $name, 'id' => $id]);
}

/**
 * Supprime une agence.
 *
 * @param int $id L'id de l'agence
 * @return void
 */
function deleteAgency($id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('DELETE FROM agency WHERE id = :id');
    $query->execute(['id' => $id]);
}

/**
 * Dit si une autre agence porte déjà ce nom.
 *
 * @param string $name Le nom cherché
 * @param int $id L'agence qu'on renomme (0 pour une création)
 * @return bool Vrai si le nom est déjà pris
 */
function agencyNameExists($name, $id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('SELECT COUNT(*) FROM agency WHERE name = :name AND id <> :id');
    $query->execute(['name' => $name, 'id' => $id]);

    return $query->fetchColumn() > 0;
}

/**
 * Dit si au moins un trajet part de cette agence ou y arrive.
 *
 * @param int $id L'id de l'agence
 * @return bool Vrai si l'agence est utilisée
 */
function agencyIsUsed($id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('SELECT COUNT(*) FROM trip WHERE departure_agency_id = :id1 OR arrival_agency_id = :id2');
    $query->execute(['id1' => $id, 'id2' => $id]);

    return $query->fetchColumn() > 0;
}
