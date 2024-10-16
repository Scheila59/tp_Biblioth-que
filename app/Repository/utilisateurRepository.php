<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Utilisateur;
use PDO;
use App\Service\AbstractConnexion;

class UtilisateurRepository extends AbstractConnexion
{
    private Utilisateur $utilisateur;

    public function getUtilisateurByEmail(string $email)
    {
        $req = "SELECT * FROM utilisateur WHERE email = ?"; // requête SQL pour récupérer un utilisateur par son email
        $stmt = $this->getConnexionBdd()->prepare($req); // préparation de la requête
        $stmt->execute([$email]); // exécution de la requête
        $utilisateurTab = $stmt->fetch(PDO::FETCH_ASSOC); // récupération des données de l'utilisateur
        $stmt->CloseCursor(); // ferme le curseur
        if (!$utilisateurTab) { // si l'utilisateur n'existe pas
            return false; // retourne false
        } else { // si l'utilisateur existe
            $utilisateur = new Utilisateur($utilisateurTab['id_utilisateur'], $utilisateurTab['identifiant'], $utilisateurTab['password'], $utilisateurTab['email'], $utilisateurTab['role']); // création de l'utilisateur
            $this->setUtilisateur($utilisateur); // set l'utilisateur
            return $this->getUtilisateur(); // retourne l'utilisateur
        }
    }


    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }


    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
