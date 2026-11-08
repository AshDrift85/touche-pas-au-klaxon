<?php

namespace App\Controller;

require_once __DIR__ . '/../../model/userModel.php';
require_once __DIR__ . '/../../model/agencyModel.php';
require_once __DIR__ . '/../../model/tripModel.php';

/**
 * Contrôleur Admin : une méthode par page.
 */
class AdminController
{
    /**
     * Page d'administration : utilisateurs, agences, trajets.
     *
     * @return void
     */
    public function index()
    {
        $this->requireAdmin();

        $users = getUsers();
        $agencies = getAgencies();
        $trips = getAllTrips();

        require __DIR__ . '/../../templates/admin.php';
    }

    /**
     * Crée une agence (id = 0) ou la renomme.
     *
     * @return void
     */
    public function saveAgency()
    {
        $this->requireAdmin();

        $name = trim($_POST['name']);
        $id = (int) $_POST['id'];

        if ($name === '') {
            $_SESSION['flash'] = "Le nom de l'agence est obligatoire.";
        } elseif (agencyNameExists($name, $id)) {
            $_SESSION['flash'] = 'Une agence porte déjà ce nom.';
        } elseif ($id === 0) {
            createAgency($name);
            $_SESSION['flash'] = "L'agence a été créée.";
        } else {
            renameAgency($id, $name);
            $_SESSION['flash'] = "L'agence a été modifiée.";
        }

        header('Location: /admin#agencies');
        exit;
    }

    /**
     * Supprime une agence si aucun trajet ne l'utilise.
     *
     * @return void
     */
    public function deleteAgency()
    {
        $this->requireAdmin();

        $id = (int) $_POST['id'];

        if (agencyIsUsed($id)) {
            $_SESSION['flash'] = "Impossible de supprimer cette agence : des trajets l'utilisent.";
        } else {
            deleteAgency($id);
            $_SESSION['flash'] = "L'agence a été supprimée.";
        }

        header('Location: /admin#agencies');
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * @return void
     */
    public function deleteTrip()
    {
        $this->requireAdmin();

        deleteTrip((int) $_POST['id']);
        $_SESSION['flash'] = 'Le trajet a été supprimé.';

        header('Location: /admin#trips');
        exit;
    }

    /**
     * Renvoie vers la connexion si ce n'est pas l'administrateur.
     *
     * @return void
     */
    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }
}
