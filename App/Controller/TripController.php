<?php

namespace App\Controller;

require_once __DIR__ . '/../../model/agencyModel.php';
require_once __DIR__ . '/../../model/tripModel.php';

/**
 * Contrôleur Trip : une méthode par page.
 */
class TripController
{
    /**
     * Page d'accueil.
     *
     * @return void
     */
    public function home()
    {
        // L'administrateur a sa propre page
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            header('Location: /admin');
            exit;
        }

        $trips = getTrips();

        require __DIR__ . '/../../templates/home.php';
    }

    /**
     * Formulaire vide pour créer un trajet.
     *
     * @return void
     */
    public function create()
    {
        $this->requireEmployee();

        $trip = [
            'departure_agency_id' => '',
            'arrival_agency_id' => '',
            'departure_at' => '',
            'arrival_at' => '',
            'total_seats' => '',
            'available_seats' => '',
        ];

        $this->showForm(null, $trip, '');
    }

    /**
     * Enregistre le nouveau trajet.
     *
     * @return void
     */
    public function store()
    {
        $this->requireEmployee();

        $error = $this->checkForm();

        if ($error !== '') {
            $this->showForm(null, $_POST, $error);
            return;
        }

        createTrip(
            $_POST['departure_agency_id'],
            $_POST['arrival_agency_id'],
            date('Y-m-d H:i:s', strtotime($_POST['departure_at'])),
            date('Y-m-d H:i:s', strtotime($_POST['arrival_at'])),
            $_POST['total_seats'],
            $_POST['available_seats'],
            $_SESSION['user']['id']
        );

        $_SESSION['flash'] = 'Le trajet a été créé.';
        header('Location: /');
        exit;
    }

    /**
     * Formulaire rempli pour modifier un trajet.
     *
     * @param int $id L'id du trajet
     * @return void
     */
    public function edit($id)
    {
        $this->requireEmployee();

        $existing = $this->getOwnTrip($id);

        $trip = [
            'departure_agency_id' => $existing['departure_agency_id'],
            'arrival_agency_id' => $existing['arrival_agency_id'],
            'departure_at' => date('Y-m-d\TH:i', strtotime($existing['departure_at'])),
            'arrival_at' => date('Y-m-d\TH:i', strtotime($existing['arrival_at'])),
            'total_seats' => $existing['total_seats'],
            'available_seats' => $existing['available_seats'],
        ];

        $this->showForm($id, $trip, '');
    }

    /**
     * Enregistre les modifications.
     *
     * @param int $id L'id du trajet
     * @return void
     */
    public function update($id)
    {
        $this->requireEmployee();

        $this->getOwnTrip($id);

        $error = $this->checkForm();

        if ($error !== '') {
            $this->showForm($id, $_POST, $error);
            return;
        }

        updateTrip(
            $id,
            $_POST['departure_agency_id'],
            $_POST['arrival_agency_id'],
            date('Y-m-d H:i:s', strtotime($_POST['departure_at'])),
            date('Y-m-d H:i:s', strtotime($_POST['arrival_at'])),
            $_POST['total_seats'],
            $_POST['available_seats']
        );

        $_SESSION['flash'] = 'Le trajet a été modifié.';
        header('Location: /');
        exit;
    }

    /**
     * Supprime un trajet (seulement le sien).
     *
     * @param int $id L'id du trajet
     * @return void
     */
    public function delete($id)
    {
        $this->requireEmployee();

        $this->getOwnTrip($id);

        deleteTrip($id);

        $_SESSION['flash'] = 'Le trajet a été supprimé.';
        header('Location: /');
        exit;
    }

    /**
     * Renvoie vers la connexion si ce n'est pas un employé connecté.
     *
     * @return void
     */
    private function requireEmployee()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] === 'admin') {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Renvoie le trajet s'il appartient à l'utilisateur, sinon retour à l'accueil.
     *
     * @param int $id L'id du trajet
     * @return array Le trajet
     */
    private function getOwnTrip($id)
    {
        $trip = getTrip($id);

        if (!$trip || $trip['author_id'] != $_SESSION['user']['id']) {
            header('Location: /');
            exit;
        }

        return $trip;
    }

    /**
     * Vérifie le formulaire : renvoie le message d'erreur, ou '' si tout est bon.
     *
     * @return string Le message d'erreur, ou une chaîne vide
     */
    private function checkForm()
    {
        $departureAt = strtotime($_POST['departure_at']);
        $arrivalAt = strtotime($_POST['arrival_at']);

        if ($_POST['departure_agency_id'] === $_POST['arrival_agency_id']) {
            return "L'agence d'arrivée doit être différente de l'agence de départ.";
        }
        if ($departureAt <= time()) {
            return 'Le départ doit avoir lieu dans le futur.';
        }
        if ($arrivalAt <= $departureAt) {
            return "L'arrivée doit être après le départ.";
        }
        if ((int) $_POST['available_seats'] > (int) $_POST['total_seats']) {
            return 'Les places disponibles ne peuvent pas dépasser le nombre total de places.';
        }

        return '';
    }

    /**
     * Affiche le formulaire.
     *
     * @param int|null $id L'id du trajet (null pour une création)
     * @param array $trip Les valeurs du formulaire
     * @param string $error Le message d'erreur à afficher
     * @return void
     */
    private function showForm($id, $trip, $error)
    {
        $agencies = getAgencies();

        require __DIR__ . '/../../templates/trip_form.php';
    }
}
