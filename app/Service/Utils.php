<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class Utils
{
    public static function ajoutImage($image, $repertoire) {
        if ($image['size'] === 0) {
        throw new Exception("Vous devez uploader une image pour l'ajout du livre");
        }

        if(!file_exists($repertoire)){
            mkdir($repertoire, 0777);
        }
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
