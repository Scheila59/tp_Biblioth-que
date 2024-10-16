<?php

declare(strict_types=1);

// déclaration du type strict

namespace App\Service;

use PDO;

abstract class AbstractConnexion
{
    private static $connexion;

    private static function setConnexionBdd()
    {
        self::$connexion = new PDO("mysql:host=$_ENV[MYSQL_HOST];dbname=$_ENV[MYSQL_DATABASE];charset=utf8", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']); // création de la connexion à la base de données
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // définition du mode d'erreur
    }

    protected function getConnexionBdd()
    {
 // méthode pour obtenir la connexion à la base de données
        if (self::$connexion === null) { // si la connexion n'existe pas
            self::setConnexionBdd(); // on la crée
        }
        return self ::$connexion; // retourne la connexion à la base de données
    }
}
