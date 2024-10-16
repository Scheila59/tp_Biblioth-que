<?php

declare(strict_types=1);

namespace App\Service;

// déclaration du namespace

use Exception;

// importation de la classe Exception

class Utils
{
    public static function ajoutImage($image, $repertoire)
    {
 // méthode pour ajouter une image
        if ($image['size'] === 0) { // si la taille de l'image est égale à 0
            throw new Exception("Vous devez uploader une image pour l'ajout du livre"); // exception si l'image n'est pas uploadée
        }

        if (!file_exists($repertoire)) { // si le répertoire n'existe pas
            mkdir($repertoire, 0777); // on le crée avec les droits 0777
        }
        $filename = uniqid() . "_" . $image['name']; // donne un id unique + le nom de l'image uploadé
        $target = $repertoire . $filename; // chemin de l'image

        if (!getimagesize($image['tmp_name'])) { // si l'image n'est pas une image valide
            throw new Exception('Vous devez uploader une image et pas autre chose!!');
        }

        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        //echo $extension;
        $extensionsTab = ['png', 'jpg', 'jpeg', 'webp']; // tableau des extensions autorisées

        if (!in_array($extension, $extensionsTab)) { // si l'extension n'est pas dans le tableau des extensions autorisées
            throw new Exception("Extension non autorisée => [ 'pdf']"); // exception si l'extension n'est pas autorisée
        }

        if ($image['size'] > 4000000) { // est égale a 4MO
            throw new Exception("Fichier trop volumineux : max 4MO");
        }

        if (!move_uploaded_file($image['tmp_name'], $target)) { // si le transfert de l'image échoue
            throw new Exception("Le transfert de l'image à échoué"); // exception si le transfert de l'image échoue
        } else {
            return $filename; // retourne le nom de l'image
        }
    }
}
