<?php

namespace App\Controller;

/**
 * Contrôleur Auth : une méthode par page.
 */
class AuthController
{
    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function login()
    {
        $error = '';

        require __DIR__ . '/../../templates/login.php';
    }

    /**
     * Vérifie l'email et le mot de passe.
     *
     * @return void
     */
    public function check()
    {
        require __DIR__ . '/../../model/userModel.php';

        $user = getUserByEmail($_POST['email']);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'role' => $user['role'],
            ];
            header('Location: /');
            exit;
        }

        $error = 'Adresse email ou mot de passe incorrect.';

        require __DIR__ . '/../../templates/login.php';
    }

    /**
     * Déconnexion.
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();

        header('Location: /');
        exit;
    }
}
