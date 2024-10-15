<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\livresRepository;
use App\Service\Utils;
use App\Service\ValidationDonnees;
use App\Controller\UtilisateurController;
class LivreController
{
    private livresRepository $repositoryLivres;
    private ValidationDonnees $validationDonnees;
    private UtilisateurController $utilisateurController;

    public function __construct()
    { // constructeur
        $this->repositoryLivres = new livresRepository; // on crée un objet de type livresRepository
        $this->validationDonnees = new ValidationDonnees(); // on crée un objet de type ValidationDonnees
        $this->utilisateurController = new UtilisateurController(); // on crée un objet de type UtilisateurController
        $isAdmin = $this->utilisateurController->isRoleAdmin();
        $isUser = $this->utilisateurController->isRoleUser();
        if ($isAdmin) {
            $this->repositoryLivres->chargementLivresBdd();
        } elseif ($isUser) {
            $livresTab = $this->repositoryLivres->getLivresByIdUtilisateur($_SESSION['utilisateur']['id_utilisateur']);
        }  // else {
            // header('location: ' . SITE_URL . 'login');
            // exit;
        // }
    }

    public function afficherLivres()
    {       
        $this->utilisateurController->redirectLogin();
        $livresTab = $this->repositoryLivres->getLivres();
        $pasDeLivre = (count($livresTab) > 0) ? false : true;
        require "../app/Views/livres.php";
    }

    public function afficherUnLivre($idLivre)
    { // fonction qui affiche un livre
        $this->utilisateurController->redirectLogin();
        $livre = $this->repositoryLivres->getLivreById($idLivre); // on récupère le livre
        ($livre !== null) ? require "../app/Views/afficherLivre.php" : require "../app/Views/error404.php"; // on affiche la page
    }

    public function ajouterLivre()
    {
        $this->utilisateurController->redirectLogin();
        require '../app/Views/ajouterLivre.php'; // on affiche la page
    }

    public function validationAjoutLivre() // fonction qui valide les données d'ajout d'un livre
    {
        $this->utilisateurController->redirectLogin();
        $erreurs = $this->validationDonnees->valider([ // on valide les données
            //'titre' => ['min:3']   
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'], // on valide le titre sous certaines conditions
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],  // on valide le nombre de pages sous certaines conditions
            'text-alternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']    // on valide le texte alternatif sous certaines conditions
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) { // si il y a des erreurs
            $_SESSION['erreurs'][] = $erreurs; // on les enregistre dans la session
            header('location: ' . SITE_URL . 'livres/a'); // on redirige vers la page d'ajout
            exit;
        }
        $image = $_FILES["image"]; // on recupere l'image
        $repertoire = "images/"; // on stocke l'image
        $nomImage = Utils::ajoutImage($image, $repertoire);  // on ajoute l'image
        $this->repositoryLivres->ajouterLivreBdd($_POST['titre'], (int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage);  // on enregistre le livre dans la BDD
        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Le livre $_POST[titre] a été ajouté avec succès!"
        ];
        header('location: ' . SITE_URL . 'livres');  // on redirige vers la page livres  
    }

    public function modifierLivre($idLivre)
    { // fonction qui permet de modifier un livre
        $this->utilisateurController->redirectLogin();
        $livre = $this->repositoryLivres->getLivreById($idLivre); // on récupère le livre
        require '../app/Views/modifierLivre.php'; // on affiche la page
    }

    public function validationModifierLivre()
    { // fonction qui valide les données de modification d'un livre
        $this->utilisateurController->redirectLogin();
        $erreurs = $this->validationDonnees->valider([ // on valide les données
            //'titre' => ['min:3']   
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'],
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],
            'text-lternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) { // si il y a des erreurs
            $_SESSION['erreurs'][] = $erreurs; // on les enregistre dans la session
            header('location: ' . SITE_URL . 'livres/a'); // on redirige vers la page d'ajout
            exit; // on quitte la fonction
        }
        $idLivre = (int)$_POST['id_livre']; // on récupère l'id du livre
        $imageActuelle = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage(); // on récupère l'url de l'image actuelle
        $imageUpload = $_FILES['image']; // on récupère l'image
        $cheminImage = "images/$imageActuelle"; // on crée le chemin de l'image
        if ($imageUpload['size'] > 0) { // si l'image est bien enregistrée
            if (file_exists($cheminImage)) { // si l'image existe déjà
                unlink($cheminImage); // on la supprime
            }
            $imageActuelle = Utils::ajoutImage($imageUpload, "images/"); // on ajoute l'image
        }
        $this->repositoryLivres->modificationLivreBdd(
            $_POST['titre'],
            (int)$_POST['nbre-de-pages'],
            $_POST['text-alternatif'],
            $imageActuelle,  // on enregistre le livre dans la BDD
            $idLivre
        );
        header('location: ' . SITE_URL . 'livres'); // on redirige vers la page livres
    }

    public function supprimerLivre($idLivre)
    { // fonction qui permet de supprimer un livre
        $this->utilisateurController->redirectLogin();
        // Récupère le nom de l'image associée au livre à supprimer
        $nomImage = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        // Crée le chemin complet du fichier image en utilisant le nom de l'image
        $filename = 'images/$nomImage';
        // Vérifie si le fichier existe, puis le supprime s'il est présent
        if (file_exists($filename)) unlink($filename);
        // Supprime le livre de la base de données
        $this->repositoryLivres->supprimerLivreBdd($idLivre);
        // Redirige l'utilisateur vers la liste des livres après la suppression
        header('location: ' . SITE_URL . 'livres');
    }
}
