<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Service\Csrf;
use App\Service\ValidationDonnees;

class UtilisateurController
{
    private UtilisateurRepository $utilisateurRepository;
    private ValidationDonnees $validationDonnees;

    public function __construct()
    {
        $this->utilisateurRepository = new UtilisateurRepository();
        $this->validationDonnees = new ValidationDonnees();
    }

    public function afficherConnexion()
    {
        if ($this->isRoleAdmin() || $this->isRoleUser()) {
            header('location: ' . SITE_URL . 'livres');
        }
        $csrfToken = Csrf::token();
        require '../app/Views/afficherConnexion.php';
    }
    public function logout()
    {
        if (isset($_SESSION['utilisateur'])) {
            unset($_SESSION['utilisateur']);
        }
        header('location: ' . SITE_URL . '');
    }
    public function connexionValidation()
    {
        // $_SESSION['biblio_csrf_token'] = '12345' ;
        Csrf::check();
        $erreurs = $this->validationDonnees->valider([ // on valide les données
            //'titre' => ['min:3']
            'email' => ['required', 'match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'], // on valide le mail sous certaines conditions
            'password' => ['required', 'match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'], // on valide le mot de passe sous certaines conditions
        ], $_POST);
        if (is_array($erreurs) && count($erreurs) > 0) { // si il y a des erreurs
            $_SESSION['erreurs'][] = $erreurs; // on les enregistre dans la session
            header('location: ' . SITE_URL . 'login'); // on redirige vers la page d'ajout
            exit;
        }
        // debug($_POST);
        // recupération utilisateur
        $_POST['email'] = trim(htmlspecialchars($_POST['email']));
        $_POST['password'] = trim(htmlspecialchars($_POST['password']));
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($_POST['email']);
        //debug($utilisateur);
        // verification email et du mot de passe
        if ($utilisateur) {
            if (password_verify($_POST['password'], $utilisateur->getPassword())) { // on vérifie le mot de passe
                $_SESSION['utilisateur']['id_utilisateur'] = $utilisateur->getIdUtilisateur(); // on met l'utilisateur en session
                $_SESSION['utilisateur']['email'] = $utilisateur->getEmail();
                $_SESSION['utilisateur']['role'] = $utilisateur->getRole();
                $_SESSION['utilisateur']['identifiant'] = $utilisateur->getIdentifiant();

                header('location: ' . SITE_URL . 'livres');
            } else {
                $_SESSION['erreurs'][] = [['email' => 'Email ou mot de passe incorrect']];
                header('location: ' . SITE_URL . 'login'); // on redirige vers la page d'ajout
                exit;
            }
        } else {
            $_SESSION['erreurs'][] = [['email' => 'Email ou mot de passe incorrect']];
            header('location: ' . SITE_URL . 'login'); // on redirige vers la page d'ajout
            exit;
        }
    }

    public function isRoleUser(): bool
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'ROLE_USER') {
            return true;
        }
        return false;
    }

    public function isRoleAdmin(): bool
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'ROLE_ADMIN') {
            return true;
        }
        return false;
    }

    public function redirectLogin()
    {
        $isAdmin = $this->isRoleAdmin();
        $isUser = $this->isRoleUser();
        if (!$isAdmin && !$isUser) {
            header('location: ' . SITE_URL . 'login');
            exit;
        }
    }
}
