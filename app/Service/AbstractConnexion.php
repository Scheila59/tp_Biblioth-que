<?php

declare(strict_types=1);

namespace App\Service;

use PDO;

abstract class AbstractConnexion
{
    private static $connexion;

    private static function setConnexionBdd() {
        self::$connexion = new PDO("mysql:host=$_ENV[MYSQL_HOST];dbname=$_ENV[MYSQL_DATABASE];charset=utf8", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getConnexionBdd() {
        if (self::$connexion === null) {
            self::setConnexionBdd();
        }
        return self ::$connexion;
    }
}
