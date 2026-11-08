<?php

require_once __DIR__ . '/database.php';

/**
 * Renvoie les trajets à venir qui ont encore des places, du plus proche au plus lointain.
 *
 * @return array La liste des trajets (avec les noms des agences et les infos de l'auteur)
 */
function getTrips()
{
    $pdo = getPdo();

    $query = $pdo->query(
        'SELECT t.id, t.author_id, t.departure_at, t.arrival_at, t.total_seats, t.available_seats,
                da.name AS departure_name, aa.name AS arrival_name,
                u.first_name AS author_first_name, u.last_name AS author_last_name,
                u.phone AS author_phone, u.email AS author_email
         FROM trip t
         JOIN agency da ON da.id = t.departure_agency_id
         JOIN agency aa ON aa.id = t.arrival_agency_id
         JOIN user u ON u.id = t.author_id
         WHERE t.departure_at > NOW() AND t.available_seats > 0
         ORDER BY t.departure_at'
    );

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Cherche un trajet par son id.
 *
 * @param int $id L'id du trajet
 * @return array|false Le trajet, ou false s'il n'existe pas
 */
function getTrip($id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('SELECT * FROM trip WHERE id = :id');
    $query->execute(['id' => $id]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Crée un trajet.
 *
 * @param int $departureAgency L'id de l'agence de départ
 * @param int $arrivalAgency L'id de l'agence d'arrivée
 * @param string $departureAt Date et heure de départ (Y-m-d H:i:s)
 * @param string $arrivalAt Date et heure d'arrivée (Y-m-d H:i:s)
 * @param int $totalSeats Nombre total de places
 * @param int $availableSeats Nombre de places disponibles
 * @param int $authorId L'id de l'utilisateur qui crée le trajet
 * @return int L'id du nouveau trajet
 */
function createTrip($departureAgency, $arrivalAgency, $departureAt, $arrivalAt, $totalSeats, $availableSeats, $authorId)
{
    $pdo = getPdo();

    $query = $pdo->prepare(
        'INSERT INTO trip (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, author_id)
         VALUES (:departure_agency, :arrival_agency, :departure_at, :arrival_at, :total_seats, :available_seats, :author_id)'
    );

    $query->execute([
        'departure_agency' => $departureAgency,
        'arrival_agency' => $arrivalAgency,
        'departure_at' => $departureAt,
        'arrival_at' => $arrivalAt,
        'total_seats' => $totalSeats,
        'available_seats' => $availableSeats,
        'author_id' => $authorId,
    ]);

    return (int) $pdo->lastInsertId();
}

/**
 * Supprime un trajet.
 *
 * @param int $id L'id du trajet
 * @return void
 */
function deleteTrip($id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('DELETE FROM trip WHERE id = :id');
    $query->execute(['id' => $id]);
}

/**
 * Modifie un trajet.
 *
 * @param int $id L'id du trajet
 * @param int $departureAgency L'id de l'agence de départ
 * @param int $arrivalAgency L'id de l'agence d'arrivée
 * @param string $departureAt Date et heure de départ (Y-m-d H:i:s)
 * @param string $arrivalAt Date et heure d'arrivée (Y-m-d H:i:s)
 * @param int $totalSeats Nombre total de places
 * @param int $availableSeats Nombre de places disponibles
 * @return void
 */
function updateTrip($id, $departureAgency, $arrivalAgency, $departureAt, $arrivalAt, $totalSeats, $availableSeats)
{
    $pdo = getPdo();

    $query = $pdo->prepare(
        'UPDATE trip
         SET departure_agency_id = :departure_agency, arrival_agency_id = :arrival_agency,
             departure_at = :departure_at, arrival_at = :arrival_at,
             total_seats = :total_seats, available_seats = :available_seats
         WHERE id = :id'
    );

    $query->execute([
        'id' => $id,
        'departure_agency' => $departureAgency,
        'arrival_agency' => $arrivalAgency,
        'departure_at' => $departureAt,
        'arrival_at' => $arrivalAt,
        'total_seats' => $totalSeats,
        'available_seats' => $availableSeats,
    ]);
}

/**
 * Renvoie tous les trajets (passés et à venir), pour l'administrateur.
 *
 * @return array La liste des trajets
 */
function getAllTrips()
{
    $pdo = getPdo();

    $query = $pdo->query(
        'SELECT t.id, t.departure_at, t.arrival_at, t.total_seats, t.available_seats,
                da.name AS departure_name, aa.name AS arrival_name
         FROM trip t
         JOIN agency da ON da.id = t.departure_agency_id
         JOIN agency aa ON aa.id = t.arrival_agency_id
         ORDER BY t.departure_at'
    );

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
