<?php

declare(strict_types=1);

session_start();

use App\Controller\LivreController;
use App\Controller\UtilisateurController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

require __DIR__ . '/app/lib/init.php';
require __DIR__ . '/app/lib/functions.php';
// debug(dirname(__DIR__));
?>
<?php
// password hash sert à créer un mot de passe hashé(decomposé par un algorithme)
// echo password_hash('12345', PASSWORD_BCRYPT); S65dghsfhg-qd!fhsJ ( quand je veux me connecter je met le mdp en clair)

$livreController = new LivreController();
$utilisateurController = new UtilisateurController();
try {
    // debug($_GET, $mode = 0);
    if (empty($_GET['page'])) {
        $livreController->getAllLivres();
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case 'livres':
                if (empty($url[1])) {
                    $livreController->afficherLivres();
                } elseif ($url[1] === 'l') {
                    $livreController->afficherUnLivre((int)$url[2]);
                } elseif ($url[1] === 'a') {
                    $livreController->ajouterLivre();
                } elseif ($url[1] === 'av') {
                    $livreController->validationAjoutLivre();
                } elseif ($url[1] === 'm') {
                    $livreController->modifierLivre((int)$url[2]);
                } elseif ($url[1] === 'mv') {
                    $livreController->validationModifierLivre();
                } elseif ($url[1] === 's') {
                    $livreController->supprimerLivre((int)$url[2]);
                } else {
                    throw new Exception("La page n'existe pas");
                }
                break;
            case 'login':
                if (empty($url[1])) {
                    $utilisateurController->afficherConnexion();
                } elseif ($url[1] === 'v') {
                    $utilisateurController->connexionValidation();
                }
                break;
            case 'logout':
                $utilisateurController->logout();
                break;
            default:
                throw new Exception("La page n'existe pas");
                break;
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    include '../app/views/error404.php';
}
