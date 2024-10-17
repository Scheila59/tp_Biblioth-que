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
    public function addUtilisateur(string $identifiant, string $email, string $password) {
        $req = "INSERT INTO utilisateur (identifiant, email, password, role, is_valide) 
                VALUES (:identifiant, :email, :password, 'ROLE_USER', FALSE)";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        return $stmt->execute();
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

    public function emailExists($email)
    {
        $req = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getAllUtilisateurs()
    {
        $req = "SELECT * FROM utilisateur";
        $stmt = $this->getConnexionBdd()->query($req);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUtilisateurById($id)
    {
        $req = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function mettreAJourUtilisateur($id, $data)
    {
        $req = "UPDATE utilisateur SET identifiant = :identifiant, email = :email, role = :role WHERE id_utilisateur = :id";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':identifiant', $data['identifiant']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    public function supprimerUtilisateur($id)
    {
        $req = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
