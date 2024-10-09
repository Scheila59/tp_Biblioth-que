<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\livresRepository;
use Exception;

class LivreController
{
    private $repositoryLivres;

    public function __construct(){
        $this->repositoryLivres = new livresRepository;
        $this->repositoryLivres->chargementLivresBdd();
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
        $image = $_FILES["image"]; // on recupere l'image
        $repertoire = "images/"; // on stocke l'image
        $nomImage = $this->ajoutImage($image, $repertoire);
        $this->repositoryLivres->ajouterLivreBdd($_POST['titre'],(int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage); 
        header('location: ' . SITE_URL . 'livres');     
    }

    public function supprimerLivre($idLivre) {
        $nomImage = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        $filename = 'images/$nomImage';
        if (file_exists($filename)) unlink($filename);
        $this->repositoryLivres->supprimerLivreBdd($idLivre);
        header('location: ' . SITE_URL . 'livres');
    }

    public function ajoutImage($image, $repertoire) {
        if (!isset($_FILES['image']) || empty($_FILES['image']))
        throw new Exception("Vous devez uploader une image pour l'ajout du livre");

        if(!file_exists($repertoire)) mkdir($repertoire, 0777);

        $filename = uniqid() . "_" . $image['name']; // donne un id unique + le nom de l'image uploadé
        $target = $repertoire . $filename;

        if (!getimagesize($image['tmp_name']))
            throw new Exception('Vous devez uploader une image et pas autre chose!!');

        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        //echo $extension;
        $extensionsTab = ['png', 'webp', 'jpg', 'jpeg'];

        if (!in_array($extension, $extensionsTab))
        throw new Exception("Extension non autorisée => ['png', 'webp', 'jpg', 'jpeg]");

        if ($image['size'] > 4000000) // est égale a 4MO
            throw new Exception("Fichier trop volumineux : max 4MO");

        if (!move_uploaded_file($image['tmp_name'], $target))
        throw new Exception("Le transfert de l'image à échoué");
    else 
        return $filename;
    }
}
