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
    public function afficherInscription()
    {
        if ($this->isRoleAdmin() || $this->isRoleUser()) {
            header('location: ' . SITE_URL . 'livres');
            exit;
        }
        //$csrfToken = Csrf::token();
        require '../app/Views/inscription.php';
    }

    public function inscriptionValidation()
    {
        // Csrf::check();
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            $erreurs = $this->validationDonnees->valider([
                'identifiant' => ['required', 'min:3'],
                'email' => ['required', 'match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'],
                'password' => ['required', 'match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'],
            ], $_POST);

            // Vérification de l'existence de l'email
            $email = trim(htmlspecialchars($_POST['email']));
            if ($this->utilisateurRepository->emailExists($email)) {
                $erreurs['email'][] = "Cette adresse e-mail est déjà utilisée.";
            }

            if (is_array($erreurs) && count($erreurs) > 0) {
                $_SESSION['erreurs'] = $erreurs;
                header('Location: ' . SITE_URL . 'inscription');
                exit;
            }

            // Nettoyage des données d'entrée
            $identifiant = trim(htmlspecialchars($_POST['identifiant']));
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $result = $this->utilisateurRepository->addUtilisateur($identifiant, $email, $password);

            if ($result) {
                $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                header('Location: ' . SITE_URL . 'login');
                exit;
            } else {
                $_SESSION['erreurs'] = [['general' => "Une erreur est survenue lors de l'inscription."]];
                header('Location: ' . SITE_URL . 'inscription');
                exit;
            }
        } catch (\Exception $e) {
            error_log("Exception dans inscriptionValidation : " . $e->getMessage());
            $_SESSION['erreurs'] = ['general' => "Une erreur inattendue est survenue."];
            header('Location: ' . SITE_URL . 'inscription');
            exit;
        }
    }

    public function listeUtilisateurs()
    {
        if (!$this->isRoleAdmin()) {
            header('Location: ' . SITE_URL . 'login');
            exit;
        }

        $utilisateurs = $this->utilisateurRepository->getAllUtilisateurs();
        require '../app/Views/admin/listeUtilisateurs.php';
    }

    public function modifierUtilisateur($id)
    {
        if (!$this->isRoleAdmin()) {
            header('Location: ' . SITE_URL . 'login');
            exit;
        }

        $utilisateur = $this->utilisateurRepository->getUtilisateurById($id);
        if (!$utilisateur) {
            $_SESSION['erreurs'] = ['Utilisateur non trouvé'];
            header('Location: ' . SITE_URL . 'admin/utilisateurs');
            exit;
        }

        require '../app/Views/admin/modifierUtilisateur.php';
    }

    public function mettreAJourUtilisateur()
    {
        if (!$this->isRoleAdmin()) {
            header('Location: ' . SITE_URL . 'login');
            exit;
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $identifiant = htmlspecialchars(trim($_POST['identifiant'] ?? ''), ENT_QUOTES, 'UTF-8');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $role = htmlspecialchars(strip_tags($_POST['role'] ?? ''));

            if (!$id || !$identifiant || !$email || !$role) {
                throw new \Exception("Données invalides");
            }

            $data = [
                'identifiant' => $identifiant,
                'email' => $email,
                'role' => $role
            ];

            $result = $this->utilisateurRepository->mettreAJourUtilisateur($id, $data);

            if ($result) {
                $_SESSION['success'] = "Utilisateur mis à jour avec succès";
            } else {
                $_SESSION['erreurs'] = ["Erreur lors de la mise à jour de l'utilisateur"];
            }
        } catch (\Exception $e) {
            $_SESSION['erreurs'] = [$e->getMessage()];
        }

        header('Location: ' . SITE_URL . 'admin/utilisateurs');
        exit;
    }

    public function supprimerUtilisateur($id)
    {
        if (!$this->isRoleAdmin()) {
            header('Location: ' . SITE_URL . 'login');
            exit;
        }

        $result = $this->utilisateurRepository->supprimerUtilisateur($id);
        if ($result) {
            $_SESSION['success'] = "Utilisateur supprimé avec succès";
        } else {
            $_SESSION['erreurs'] = ["Erreur lors de la suppression de l'utilisateur"];
        }

        header('Location: ' . SITE_URL . 'admin/utilisateurs');
        exit;
    }
}
