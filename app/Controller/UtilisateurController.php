<?php

declare(strict_types=1);

namespace App\Controller;

class UtilisateurController 
{
    private UtilisateurRepository $utilisateurRepository;

    public function __construct()
    {
        $this->utilisateurRepository = new UtilisateurRepository();
    }

    public function afficherConnexion() {
        require '../app/Views/afficherConnexion.php';
    }

    public function connexionValidation() 
    {
        debug($_POST);
        // recupération utilisateur
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($_POST['email']);
        // verification email et du mot de passe
        
    }
}
