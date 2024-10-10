<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\livresRepository;
use App\Service\Utils;
use App\Service\ValidationDonnees;

class LivreController
{
    private livresRepository $repositoryLivres;
    private ValidationDonnees $validationDonnees;

    public function __construct(){
        $this->repositoryLivres = new livresRepository;
        $this->repositoryLivres->chargementLivresBdd();
        $this->validationDonnees = new ValidationDonnees();
    }

    public function afficherLivres() {
        $livresTab = $this->repositoryLivres->getLivres();
        $pasDeLivre = (count($livresTab) > 0) ? false : true;
        require "../app/Views/livres.php";
    }

    public function afficherUnLivre($idLivre) {
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        ($livre!==null) ? require "../app/Views/afficherLivre.php" : require "../app/Views/error404.php";
    }

    public function ajouterLivre() {
        require '../app/Views/ajouterLivre.php';
    }

    public function validationAjoutLivre()
    {   
        $erreurs = $this->validationDonnees->valider([
            'titre' => ['required', 'match:/^[A-Z][a-z\- ]+$/'],
            'nbre-de-pages' =>['min:1', 'max:11']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'][] = $erreurs;
            header('location: ' . SITE_URL . 'livres/a');
            exit;
        }
        $image = $_FILES["image"]; // on recupere l'image
        $repertoire = "images/"; // on stocke l'image
        $nomImage = Utils::ajoutImage($image, $repertoire);
        $this->repositoryLivres->ajouterLivreBdd($_POST['titre'],(int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage); 
        header('location: ' . SITE_URL . 'livres');     
    }

    public function modifierLivre($idLivre) {
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        require '../app/Views/modifierLivre.php';
    }

    public function validationModifierLivre() {
        $idLivre = (int)$_POST['id_livre'];
        $imageActuelle = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        $imageUpload = $_FILES['image'];
        $cheminImage = "images/$imageActuelle";
        if($imageUpload['size'] > 0) {
            if (file_exists($cheminImage)) {
                unlink($cheminImage);
            }
            $imageActuelle = Utils::ajoutImage($imageUpload, "images/");
        } 
        $this->repositoryLivres->modificationLivreBdd($_POST['titre'],(int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $imageActuelle, 
    $idLivre); 
        header('location: ' . SITE_URL . 'livres');
    }

    public function supprimerLivre($idLivre) {
        $nomImage = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        $filename = 'images/$nomImage';
        if (file_exists($filename)) unlink($filename);
        $this->repositoryLivres->supprimerLivreBdd($idLivre);
        header('location: ' . SITE_URL . 'livres');
    }    
}
